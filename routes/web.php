<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\WeekdaysController;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

Route::post('/send-message', function (Request $request) {
    try {
        Mail::raw(
            "Ism: ".$request->fullname."\n".
            "Email: ".$request->email."\n\n".
            "Xabar:\n".$request->message,
            function ($mail) use ($request) {
                $mail->to('husniddin13124041@gmail.com')
                     ->from($request->email)
                     ->subject('Yangi xabar');
            }
        );

        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Xabar muvaffaqiyatli yuborildi!']);
        }

        return back()->with('success', 'Xabar muvaffaqiyatli yuborildi!');
    } catch (\Exception $e) {
        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Xabarni yuborishda xatolik yuz berdi.'], 500);
        }

        return back()->with('error', 'Xabarni yuborishda xatolik yuz berdi.');
    }
});

Route::fallback(function () {
    return response()->view('pages.404', [], 404);
});

// Route::get('setwebhook', function () {
//     $response = Telegram::setWebhook(['url' => 'https://fbd5e36f17a6.ngrok-free.app/api/telegram/webhook']);
// });

// google auth uchun route lar
Route::get('/auth/google', function () {
    return Socialite::driver('google')
        ->scopes(['openid', 'profile', 'email'])
        ->redirect();
})->name('google.redirect');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    $user = User::updateOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),       // endi null bo‘lmaydi ✅
            'avatar' => $googleUser->getAvatar(),      // endi null bo‘lmaydi ✅
            'password' => bcrypt(Str::random(16)),
        ]
    );
    Auth::login($user);
    return redirect('/');
});

// AI test route
Route::get('/ai', function () {

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('DEEPSEEK_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post(env('DEEPSEEK_BASE_URL') . '/chat/completions', [
        "model" => "deepseek-chat", // asosiy model
        "messages" => [
            ["role" => "user", "content" => "Salom! Qandaysan?"],
        ],
    ]);
    return $response->json();
});

// Asosiy sahifalar uchun route lar
Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/blog-grid', [PageController::class, 'blogGrid'])->name('blog-grid');
Route::get('/404', [PageController::class, 'notFound'])->name('404');
Route::get('/searchMap', [PageController::class, 'searchMap'])->name('searchMap');
Route::get('/search', [PageController::class, 'search'])->name('search');
Route::get('/blog-single/{id}', [PageController::class, 'blogSingle'])->name('blog-single');

// auth uchun route lar
Route::middleware('guest')->group(function () {
    // signin va signup sahifalari uchun route lar
    Route::get('/signin', [PageController::class, 'signin'])->name('signin');
    Route::get('/signup', [PageController::class, 'signup'])->name('signup');
    // register va login uchun route lar
    Route::post('register', [LogController::class, 'register'])->name('register');
    Route::post('login', [LogController::class, 'login'])->name('login');
});
// auth bo‘lgan foydalanuvchilar uchun route lar
Route::middleware('auth')->group(function () {
    // profile uchun route
    Route::get('/profile', [UserDataController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [UserDataController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserDataController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserDataController::class, 'destroy'])->name('profile.destroy');
    // chat uchun route lar
    Route::get('/chat',                  [ChatController::class, 'chat'])->name('chat.chat');
    Route::post('/chat/save',            [ChatController::class, 'saveChat'])->name('chat.save');
    Route::post('/chat/new-session',     [ChatController::class, 'newSession'])->name('chat.new-session');
    Route::get('/chat/session/{id}',     [ChatController::class, 'getSession'])->name('chat.get-session');
    Route::get('/chat/sessions',         [ChatController::class, 'getSessions'])->name('chat.get-sessions');
    Route::post('/chat/search-centers',  [ChatController::class, 'searchCenters'])->name('chat.search-centers');

    // ── RIASEC ──
    Route::get('/riasec',                [ChatController::class, 'riasec'])->name('chat.riasec');
    Route::post('/riasec/save',          [ChatController::class, 'saveRiasec'])->name('riasec.save');

    // ── Quiz ──
    Route::get('/quiz',                  [ChatController::class, 'quiz'])->name('chat.quiz');
    // course uchun route
    Route::resource('course', CourseController::class);
    // teacher uchun route lar
    Route::post('/teacher/store/{id}', [TeacherController::class, 'store'])->name('teacher.storeid');
    Route::get('/teacher/announcement/{id}', [TeacherController::class, 'announcement'])->name('teacher.announcement');
    Route::post('/teacher/add_announcement/{id}', [TeacherController::class, 'add_announcement'])->name('teacher.add_announcement');
    Route::post('/teacher/delete_announcement/{id}', [TeacherController::class, 'delete_announcement'])->name('teacher.delete_announcement');
    Route::resource('teacher', TeacherController::class);
    // subject uchun route lar
    Route::post('/subject/store/{id}', [SubjectController::class, 'store'])->name('subject.storeid');
    Route::resource('subject', SubjectController::class);
    // comment uchun route lar
    Route::post('comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::post('comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
    Route::post('comment/favoriteStore', [CommentController::class, 'favoriteStore'])->name('comment.favoriteStore');
    // image uchun route lar
    Route::get('course/editImage/{id}', [ImageController::class, 'edit'])->name('course.editImage');
    Route::post('course/deleteImage/{id}', [ImageController::class, 'delete'])->name('course.deleteImage');
    Route::post('course/storeImages/{id}', [ImageController::class, 'store'])->name('course.storeImages');
    // weekdays uchun route lar
    Route::get('course/weekday/{id}', [WeekdaysController::class, 'edit'])->name('course.weekday');
    Route::post('course/weekdayUpdate/{id}', [WeekdaysController::class, 'update'])->name('course.weekdayUpdate');
    Route::post('course/weekdayDelete/{id}', [WeekdaysController::class, 'delete'])->name('course.weekdayDelete');
    // connect uchun route lar
    Route::get('connect/edit/{id}', [ConnectController::class, 'edit'])->name('connect.edit');
    Route::post('connect/delete/{id}', [ConnectController::class, 'delete'])->name('connect.delete');
    Route::post('connect/store/{id}', [ConnectController::class, 'store'])->name('connect.store');
    // logout uchun route
    Route::post('logout', [LogController::class, 'logout'])->name('logout');
});
