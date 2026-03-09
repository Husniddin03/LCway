<?php

namespace App\Http\Controllers;

use App\Models\AiChat;
use App\Models\ChatSession;
use App\Models\LearningCenter;
use App\Models\RiasecResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /* ── CHAT PAGE ── */

    public function chat(Request $request)
    {
        $user = Auth::user();

        $sessions = ChatSession::where('user_id', $user->id)
            ->with('lastMessage')
            ->latest()
            ->get();

        $sessionId      = $request->query('session');
        $currentSession = null;
        $messages       = collect();

        if ($sessionId) {
            $currentSession = ChatSession::where('user_id', $user->id)
                ->where('id', $sessionId)->first();
        }

        if (!$currentSession) {
            $currentSession = ChatSession::where('user_id', $user->id)
                ->where('status', 'active')->latest()->first();
        }

        if ($currentSession) {
            $messages = $currentSession->messages;
        }

        return view('chat.chat', compact('sessions', 'currentSession', 'messages'));
    }

    /* ── YANGI SESSIYA ── */

    public function newSession()
    {
        $session = ChatSession::create([
            'user_id' => Auth::id(),
            'title'   => 'Yangi suhbat',
            'status'  => 'active',
        ]);

        return response()->json(['ok' => true, 'session_id' => $session->id]);
    }

    /* ── XABAR SAQLASH ── */

    public function saveChat(Request $request)
    {
        $request->validate([
            'session_id'   => 'nullable|integer',
            'user_message' => 'required|string|max:5000',
            'ai_response'  => 'required|string',
            'model'        => 'nullable|string|max:100',
        ]);

        if (!Auth::check()) return response()->json(['ok' => false], 401);

        $userId = Auth::id();
        $model  = $request->input('model', 'deepseek/deepseek-r1');

        $session = null;
        if ($request->session_id) {
            $session = ChatSession::where('user_id', $userId)
                ->where('id', $request->session_id)->first();
        }

        if (!$session || $session->isFull()) {
            $session = ChatSession::create([
                'user_id' => $userId,
                'title'   => mb_substr($request->user_message, 0, 45),
                'status'  => 'active',
            ]);
        }

        AiChat::insert([
            ['user_id' => $userId, 'session_id' => $session->id, 'role' => 'user',      'content' => $request->user_message, 'model' => $model, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $userId, 'session_id' => $session->id, 'role' => 'assistant', 'content' => $request->ai_response,  'model' => $model, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $newCount = $session->message_count + 2;
        $session->update([
            'message_count' => $newCount,
            'status'        => $newCount >= ChatSession::MAX_MESSAGES ? 'closed' : 'active',
        ]);

        return response()->json([
            'ok'         => true,
            'session_id' => $session->id,
            'is_full'    => $session->fresh()->isFull(),
        ]);
    }

    /* ── MARKAZ QIDIRISH — sof MySQL LIKE, hech qanday paket yo'q ── */

    public function searchCenters(Request $request)
    {
        $request->validate(['keywords' => 'required|array']);
        $kw = $request->keywords;

        $province = $kw['province'] ?? null;   // viloyat nomi
        $subjects = $kw['subjects'] ?? [];     // fanlar ro'yxati
        $query    = $kw['query']    ?? null;   // umumiy qidiruv matni

        $q = LearningCenter::query()
            ->with(['subjects.subject', 'teachers'])
            ->select('id','name','type','about','province','region','address','student_count');

        // 1. Viloyat bo'yicha filter
        if ($province) {
            $q->where('province', 'LIKE', "%{$province}%");
        }

        // 2. Fan nomi bo'yicha JOIN filter
        if (!empty($subjects)) {
            $q->where(function ($outer) use ($subjects) {
                // subjects_of_learning_centers → subjects jadvalidan qidirish
                $outer->whereHas('subjects.subject', function ($inner) use ($subjects) {
                    $inner->where(function ($sub) use ($subjects) {
                        foreach ($subjects as $s) {
                            $sub->orWhere('name', 'LIKE', "%{$s}%");
                        }
                    });
                });
            });
        }

        // 3. Umumiy matn qidiruvi (nom, haqida, manzil)
        if ($query) {
            $q->where(function ($w) use ($query) {
                $w->where('name',    'LIKE', "%{$query}%")
                  ->orWhere('about', 'LIKE', "%{$query}%")
                  ->orWhere('address','LIKE',"%{$query}%");
            });
        }

        // 4. Eng ko'p o'quvchisi bo'lgan markazlarni ustiga qo'yish
        $centers = $q->orderByDesc('student_count')->limit(8)->get();

        // 5. Viloyat bo'yicha hech narsa topilmasa — kengaytirilgan qidiruv
        if ($centers->isEmpty() && $province) {
            $centers = LearningCenter::with(['subjects.subject', 'teachers'])
                ->select('id','name','type','about','province','region','address','student_count')
                ->where('province', 'LIKE', "%{$province}%")
                ->orderByDesc('student_count')
                ->limit(8)
                ->get();
        }

        // 6. AI uchun kontekst matni (qisqa va aniq)
        $context = $centers->map(function ($c) {
            $subs = $c->subjects->map(function ($s) {
                $price = $s->price
                    ? number_format((int)$s->price, 0, '.', ' ') . " so'm"
                    : '';
                return ($s->subject?->name ?? '') . ($price ? " ({$price})" : '');
            })->filter()->join(', ');

            $teachers = $c->teachers->pluck('name')->join(', ');

            return implode(' | ', array_filter([
                "#{$c->id} {$c->name} ({$c->type})",
                "{$c->province}, {$c->region}",
                $c->address,
                $c->about ? mb_substr($c->about, 0, 80) : null,
                $subs     ? "Fanlar: {$subs}"            : null,
                $c->student_count ? "O'quvchilar: {$c->student_count}" : null,
                $teachers ? "O'qituvchilar: {$teachers}" : null,
            ]));
        })->join("\n");

        return response()->json([
            'ok'      => true,
            'context' => $context,
            'count'   => $centers->count(),
        ]);
    }

    /* ── SESSIYA TARIXI ── */

    public function getSession($id)
    {
        $session = ChatSession::where('user_id', Auth::id())
            ->with('messages')
            ->findOrFail($id);

        return response()->json([
            'ok'      => true,
            'session' => [
                'id'            => $session->id,
                'title'         => $session->title,
                'status'        => $session->status,
                'message_count' => $session->message_count,
            ],
            'messages' => $session->messages->map(fn($m) => [
                'role'       => $m->role,
                'content'    => $m->content,
                'created_at' => $m->created_at->format('H:i'),
            ]),
            'is_full' => $session->isFull(),
        ]);
    }

    /* ── SIDEBAR SESSIYALAR ── */

    public function getSessions()
    {
        $sessions = ChatSession::where('user_id', Auth::id())
            ->with('lastMessage')->latest()->get()
            ->map(fn($s) => [
                'id'            => $s->id,
                'title'         => $s->title,
                'status'        => $s->status,
                'message_count' => $s->message_count,
                'is_full'       => $s->isFull(),
                'last_message'  => $s->lastMessage
                    ? mb_substr($s->lastMessage->content, 0, 55) : null,
                'created_at'    => $s->created_at->format('d.m H:i'),
            ]);

        return response()->json(['ok' => true, 'sessions' => $sessions]);
    }

    /* ── RIASEC ── */

    public function quiz()   { $history = Auth::check()
            ? RiasecResult::where('user_id', Auth::id())->latest()->take(10)->get()
            : collect(); return view('chat.quiz', compact('history'));   }
    public function answer() { return view('chat.answer'); }
    public function think()  { return redirect()->route('chat.answer'); }

    public function riasec()
    {
        
        return view('chat.riasec', compact('history'));
    }

    public function saveRiasec(Request $request)
    {
        $request->validate([
            'r_score'           => 'required|integer|min:0|max:100',
            'i_score'           => 'required|integer|min:0|max:100',
            'a_score'           => 'required|integer|min:0|max:100',
            's_score'           => 'required|integer|min:0|max:100',
            'e_score'           => 'required|integer|min:0|max:100',
            'c_score'           => 'required|integer|min:0|max:100',
            'ai_recommendation' => 'nullable|string',
        ]);

        if (!Auth::check()) return response()->json(['ok' => false], 401);

        $result = RiasecResult::create(array_merge(
            $request->only(['r_score','i_score','a_score','s_score','e_score','c_score','ai_recommendation']),
            ['user_id' => Auth::id()]
        ));

        return response()->json(['ok' => true, 'id' => $result->id]);
    }
}