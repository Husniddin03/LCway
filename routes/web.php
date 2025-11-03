<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\CourseController;
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


Route::fallback(function () {
    return response()->view('pages.404', [], 404);
});

// Route::get('setwebhook', function () {
//     $response = Telegram::setWebhook(['url' => 'https://fbd5e36f17a6.ngrok-free.app/api/telegram/webhook']);
// });


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



Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/blog-grid', [PageController::class, 'blogGrid'])->name('blog-grid');
Route::get('/404', [PageController::class, 'notFound'])->name('404');
Route::post('/searchMap', [PageController::class, 'searchMap'])->name('searchMap');
Route::post('/search', [PageController::class, 'search'])->name('search');

Route::middleware('guest')->group(function () {
    Route::get('/signin', [PageController::class, 'signin'])->name('signin');
    Route::get('/signup', [PageController::class, 'signup'])->name('signup');

    Route::post('register', [LogController::class, 'register'])->name('register');
    Route::post('login', [LogController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/blog-single/{id}', [PageController::class, 'blogSingle'])->name('blog-single');
    Route::post('logout', [LogController::class, 'logout'])->name('logout');
    Route::resource('course', CourseController::class);
    Route::post('/teacher/store/{id}', [TeacherController::class, 'store'])->name('teacher.storeid');
    Route::get('/teacher/announcement/{id}', [TeacherController::class, 'announcement'])->name('teacher.announcement');
    Route::post('/teacher/add_announcement/{id}', [TeacherController::class, 'add_announcement'])->name('teacher.add_announcement');
    Route::post('/teacher/delete_announcement/{id}', [TeacherController::class, 'delete_announcement'])->name('teacher.delete_announcement');
    Route::resource('teacher', TeacherController::class);
    Route::post('/subject/store/{id}', [SubjectController::class, 'store'])->name('subject.storeid');
    Route::resource('subject', SubjectController::class);

    Route::post('comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::post('comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
    Route::post('comment/favoriteStore', [CommentController::class, 'favoriteStore'])->name('comment.favoriteStore');

    Route::get('course/editImage/{id}', [ImageController::class, 'edit'])->name('course.editImage');
    Route::post('course/deleteImage/{id}', [ImageController::class, 'delete'])->name('course.deleteImage');
    Route::post('course/storeImages/{id}', [ImageController::class, 'store'])->name('course.storeImages');

    Route::get('course/weekday/{id}', [WeekdaysController::class, 'edit'])->name('course.weekday');
    Route::post('course/weekdayUpdate/{id}', [WeekdaysController::class, 'update'])->name('course.weekdayUpdate');
    Route::post('course/weekdayDelete/{id}', [WeekdaysController::class, 'delete'])->name('course.weekdayDelete');


    Route::get('connect/edit/{id}', [ConnectController::class, 'edit'])->name('connect.edit');
    Route::post('connect/delete/{id}', [ConnectController::class, 'delete'])->name('connect.delete');
    Route::post('connect/store/{id}', [ConnectController::class, 'store'])->name('connect.store');
});
