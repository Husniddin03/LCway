<?php

use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LearningCenterController as AdminLearningCenterController;
use App\Http\Controllers\Admin\SubjectController as AdminSubjectController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Bot\TelegramBotController;
use Illuminate\Support\Facades\Route;

Route::post('telegram/webhook', [TelegramBotController::class, 'handle']);

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
| Barcha admin API routes 'auth:sanctum' va 'admin' middleware bilan himoyalangan
*/

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->name('api.')->group(function () {

    // Dashboard
    Route::get('/dashboard/statistics', [DashboardController::class, 'statistics'])->name('dashboard.statistics');
    Route::get('/dashboard/activities', [DashboardController::class, 'recentActivities'])->name('dashboard.activities');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart-data');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/bulk-update', [AdminUserController::class, 'bulkUpdate'])->name('users.bulk-update');
    Route::post('/users/bulk-delete', [AdminUserController::class, 'bulkDelete'])->name('users.bulk-delete');
    Route::post('/users/{id}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Learning Centers
    Route::get('/centers', [AdminLearningCenterController::class, 'index'])->name('centers.index');
    Route::post('/centers', [AdminLearningCenterController::class, 'store'])->name('centers.store');
    Route::get('/centers/{id}', [AdminLearningCenterController::class, 'show'])->name('centers.show');
    Route::put('/centers/{id}', [AdminLearningCenterController::class, 'update'])->name('centers.update');
    Route::delete('/centers/{id}', [AdminLearningCenterController::class, 'destroy'])->name('centers.destroy');
    Route::post('/centers/bulk-update', [AdminLearningCenterController::class, 'bulkUpdate'])->name('centers.bulk-update');
    Route::post('/centers/bulk-delete', [AdminLearningCenterController::class, 'bulkDelete'])->name('centers.bulk-delete');
    Route::post('/centers/{id}/toggle-verification', [AdminLearningCenterController::class, 'toggleVerification'])->name('centers.toggle-verification');
    Route::post('/centers/{id}/toggle-premium', [AdminLearningCenterController::class, 'togglePremium'])->name('centers.toggle-premium');
    Route::get('/centers-pending', [AdminLearningCenterController::class, 'pending'])->name('centers.pending');
    Route::get('/centers-statistics', [AdminLearningCenterController::class, 'statistics'])->name('centers.statistics');
    Route::delete('/center-images/{imageId}', [AdminLearningCenterController::class, 'deleteImage'])->name('centers.delete-image');

    // Teachers
    Route::get('/teachers', [AdminTeacherController::class, 'index'])->name('teachers.index');
    Route::post('/teachers', [AdminTeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{id}', [AdminTeacherController::class, 'show'])->name('teachers.show');
    Route::put('/teachers/{id}', [AdminTeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [AdminTeacherController::class, 'destroy'])->name('teachers.destroy');
    Route::post('/teachers/bulk-delete', [AdminTeacherController::class, 'bulkDelete'])->name('teachers.bulk-delete');
    Route::get('/teachers-statistics', [AdminTeacherController::class, 'statistics'])->name('teachers.statistics');

    // Subjects
    Route::get('/subjects', [AdminSubjectController::class, 'index'])->name('subjects.index');
    Route::post('/subjects', [AdminSubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{id}', [AdminSubjectController::class, 'show'])->name('subjects.show');
    Route::put('/subjects/{id}', [AdminSubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{id}', [AdminSubjectController::class, 'destroy'])->name('subjects.destroy');
    Route::post('/subjects/bulk-delete', [AdminSubjectController::class, 'bulkDelete'])->name('subjects.bulk-delete');
    Route::get('/subjects-statistics', [AdminSubjectController::class, 'statistics'])->name('subjects.statistics');

    // Comments
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::get('/comments/{id}', [AdminCommentController::class, 'show'])->name('comments.show');
    Route::put('/comments/{id}', [AdminCommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{id}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{id}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
    Route::post('/comments/bulk-approve', [AdminCommentController::class, 'bulkApprove'])->name('comments.bulk-approve');
    Route::post('/comments/bulk-delete', [AdminCommentController::class, 'bulkDelete'])->name('comments.bulk-delete');
    Route::get('/comments-pending', [AdminCommentController::class, 'pending'])->name('comments.pending');
    Route::get('/comments-statistics', [AdminCommentController::class, 'statistics'])->name('comments.statistics');
});