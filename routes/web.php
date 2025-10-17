<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::fallback(function () {
    return response()->view('pages.404', [], 404);
});

// Route::get('setwebhook', function () {
//     $response = Telegram::setWebhook(['url' => 'https://fbd5e36f17a6.ngrok-free.app/api/telegram/webhook']);
// });


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
    Route::resource('teacher', TeacherController::class);
    Route::post('/subject/store/{id}', [SubjectController::class, 'store'])->name('subject.storeid');
    Route::resource('subject', SubjectController::class);
    Route::post('comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::post('comment/favoriteStore', [CommentController::class, 'favoriteStore'])->name('comment.favoriteStore');
});
