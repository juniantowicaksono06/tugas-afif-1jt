<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\AttendanceService;

class AttendanceServiceProvider extends ServiceProvider
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
    public function boot(AttendanceService $userService): void
    {
        View::composer('*', function ($view) use ($userService) {
            $view->with('attendance', $userService->getAttendance());
        });
    }
}
