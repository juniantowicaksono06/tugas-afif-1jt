<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\UserProfileService;

class UserProfileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(UserProfileService $userService): void
    {
        View::composer('*', function ($view) use ($userService) {
            $view->with('userProfile', $userService->getProfile());
        });
    }
}
