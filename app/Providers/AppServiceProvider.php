<?php

namespace App\Providers;

use App\Models\LearningCenter;
use App\Models\LearningCentersComment;
use App\Models\Teacher;
use App\Models\User;
use App\Observers\LearningCenterObserver;
use App\Observers\LearningCentersCommentObserver;
use App\Observers\TeacherObserver;
use App\Observers\UserObserver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        User::observe(UserObserver::class);
        LearningCenter::observe(LearningCenterObserver::class);
        Teacher::observe(TeacherObserver::class);
        LearningCentersComment::observe(LearningCentersCommentObserver::class);
        
        Carbon::setLocale('uz_Latn');
        
        View::composer('components.layout', function ($view) {
            $view->with('AllCenters', LearningCenter::all());
        });

        Gate::define('isOun', function (User $user, LearningCenter $center) {
            // First check direct users_id column (more reliable)
            if ($center->users_id !== null && $user->id === $center->users_id) {
                return true;
            }

            // Fallback to user relationship check
            if (!$center->relationLoaded('user')) {
                $center->load('user');
            }
            return $center->user && $user->id === $center->user->id;
        });

        Gate::define('myComment', function (User $user, LearningCentersComment $comment) {
            return $user->id === $comment->user->id;
        });
    }
}
