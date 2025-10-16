<?php

namespace App\Providers;

use App\Models\LearningCenter;
use App\Models\User;
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
        Carbon::setLocale('uz_Latn');
        View::composer('components.layout', function ($view) {
            $view->with('AllCenters', LearningCenter::all());
        });

        Gate::define('update-post', function (User $user, $id) {
            return $user->id === $id;
        });
    }
}
