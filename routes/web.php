<?php

use App\Http\Controllers\Web\LanguageController;
use App\Http\Controllers\Web\ChatController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Api\CenterManageController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\UserDataController;
use App\Http\Controllers\Web\UserDashboardController;
use App\Http\Controllers\Web\ImageController;
use App\Http\Controllers\Auth\LogController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\WeekdaysController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Centers;
use App\Livewire\Admin\Center\Index as CenterIndex;
use App\Livewire\Admin\Center\Create as CenterCreate;
use App\Livewire\Admin\Center\Edit as CenterEdit;
use App\Livewire\Admin\Center\Show as CenterShow;
use App\Livewire\Admin\Center\Map as CenterMap;
use App\Livewire\Admin\Teachers;
use App\Livewire\Admin\Subjects;
use App\Livewire\Admin\Comments;
use App\Livewire\Admin\Images;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\LearningCenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

// Explicit route model binding for 'center' parameter
Route::bind('center', function ($value) {
    return LearningCenter::where('slug', $value)->firstOrFail();
});

// Explicit route model binding for 'course' parameter (for resource routes)
Route::bind('course', function ($value) {
    return LearningCenter::where('slug', $value)->firstOrFail();
});

// Asosiy sahifalar uchun route lar
Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/centers', [PageController::class, 'centers'])->name('centers');
Route::get('/404', [PageController::class, 'notFound'])->name('404');
Route::get('/searchMap', [PageController::class, 'searchMap'])->name('searchMap');
Route::get('/search', [PageController::class, 'search'])->name('search');
Route::get('/center/{center}', [PageController::class, 'center'])->name('center');

// Language switching route
Route::get('/language/{lang}', [LanguageController::class, 'switch'])->name('language.switch');

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
    // User Dashboard
    Route::get('/my-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/my-centers', [UserDashboardController::class, 'centers'])->name('user.centers');
    Route::get('/my-centers/{center:slug}/manage', [UserDashboardController::class, 'show'])->name('user.center.manage');

    // API Routes for Center Management (Modal-based)
    Route::prefix('api/centers/{center:slug}')->group(function () {
        // Connections
        Route::post('/connections', [CenterManageController::class, 'storeConnection']);
        Route::put('/connections/{connection}', [CenterManageController::class, 'updateConnection']);
        Route::delete('/connections/{connection}', [CenterManageController::class, 'destroyConnection']);

        // Teachers
        Route::post('/teachers', [CenterManageController::class, 'storeTeacher']);
        Route::put('/teachers/{teacher}', [CenterManageController::class, 'updateTeacher']);
        Route::delete('/teachers/{teacher}', [CenterManageController::class, 'destroyTeacher']);
        Route::post('/teachers/{teacher}/subjects', [CenterManageController::class, 'assignTeacherSubjects']);

        // Subjects
        Route::post('/subjects', [CenterManageController::class, 'storeSubject']);
        Route::put('/subjects/{subject}', [CenterManageController::class, 'updateSubject']);
        Route::delete('/subjects/{subject}', [CenterManageController::class, 'destroySubject']);

        // Images
        Route::post('/images', [CenterManageController::class, 'storeImage']);
        Route::post('/images/multiple', [CenterManageController::class, 'storeMultipleImages']);
        Route::delete('/images/{image}', [CenterManageController::class, 'destroyImage']);

        // Weekdays
        Route::get('/weekdays', [CenterManageController::class, 'getWeekdays']);
        Route::post('/weekdays', [CenterManageController::class, 'storeWeekday']);
        Route::put('/weekdays/{weekday}', [CenterManageController::class, 'updateWeekday']);
        Route::delete('/weekdays/{weekday}', [CenterManageController::class, 'destroyWeekday']);
    });

    // profile uchun route
    Route::get('/profile', [UserDataController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [UserDataController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserDataController::class, 'update'])->name('profile.update');
    Route::put('/profile/change-password', [UserDataController::class, 'changePassword'])->name('profile.change-password');
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
    Route::post('/teacher/store/{center}', [TeacherController::class, 'store'])->name('teacher.storeid');
    Route::get('/teacher/announcement/{center}', [TeacherController::class, 'announcement'])->name('teacher.announcement');
    Route::post('/teacher/add_announcement/{center}', [TeacherController::class, 'add_announcement'])->name('teacher.add_announcement');
    Route::post('/teacher/delete_announcement/{center}', [TeacherController::class, 'delete_announcement'])->name('teacher.delete_announcement');
    Route::resource('teacher', TeacherController::class);
    // subject uchun route lar
    Route::post('/subject/store/{center}', [SubjectController::class, 'store'])->name('subject.storeid');
    Route::resource('subject', SubjectController::class);
    // comment uchun route lar
    Route::post('comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::post('comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
    Route::post('comment/favoriteStore', [CommentController::class, 'favoriteStore'])->name('comment.favoriteStore');
    // image uchun route lar
    Route::get('center/editImage/{center}', [ImageController::class, 'edit'])->name('course.editImage');
    Route::post('center/deleteImage/{id}', [ImageController::class, 'delete'])->name('course.deleteImage');
    Route::post('center/storeImages/{center}', [ImageController::class, 'store'])->name('course.storeImages');
    // weekdays uchun route lar
    Route::get('center/weekday/{center}', [WeekdaysController::class, 'edit'])->name('course.weekday');
    Route::post('center/weekdayUpdate/{center}', [WeekdaysController::class, 'update'])->name('course.weekdayUpdate');
    Route::post('center/weekdayAdd/{center}', [WeekdaysController::class, 'add'])->name('course.weekdayAdd');
    Route::post('center/weekdayDelete/{id}', [WeekdaysController::class, 'delete'])->name('course.weekdayDelete');
    // connect uchun route lar
    Route::get('connect/edit/{center}', [ConnectController::class, 'edit'])->name('connect.edit');
    Route::post('connect/delete/{id}', [ConnectController::class, 'delete'])->name('connect.delete');
    Route::post('connect/store/{center}', [ConnectController::class, 'store'])->name('connect.store');
    // logout uchun route
    Route::post('logout', [LogController::class, 'logout'])->name('logout');
});

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
    return response()->view('errors.404', [], 404);
});

Route::get('setwebhook', function () {
    $response = Telegram::setWebhook(['url' => 'https://obesely-squirrellike-byron.ngrok-free.dev/api/telegram/webhook']);
    return $response;
});

// google auth uchun route lar
Route::get('/auth/google', function () {
    return Socialite::driver('google')
        ->scopes(['openid', 'profile', 'email'])
        ->redirect();
})->name('google.redirect');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();
    $user = User::where('google_id', $googleUser->id)->first();
    if(!$user){
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),       // endi null bo‘lmaydi ✅
                'avatar' => $googleUser->getAvatar(),      // endi null bo‘lmaydi ✅
                'password' => bcrypt(Str::random(16)),
                'password_status' => 'google',
            ]
        );
    }
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

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Dashboard::class);
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', Users::class)->name('users');
    
    // Centers CRUD
    Route::get('/centers', CenterIndex::class)->name('centers');
    Route::get('/centers/create', CenterCreate::class)->name('centers.create');
    Route::get('/centers/{center}/edit', CenterEdit::class)->name('centers.edit');
    Route::get('/centers/{center}', CenterShow::class)->name('centers.show');
    Route::get('/centers-map', CenterMap::class)->name('centers.map');
    
    Route::get('/teachers', Teachers::class)->name('teachers');
    Route::get('/subjects', Subjects::class)->name('subjects');
    Route::get('/comments', Comments::class)->name('comments');
    Route::get('/images', Images::class)->name('images');
});

require __DIR__.'/test_bot.php';
