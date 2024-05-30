<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\MenuService;

class MenuServiceProvider extends ServiceProvider
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
    public function boot(MenuService $menuService): void
    {
        View::composer('*', function ($view) use ($menuService) {
            $view->with('menus', $menuService->getMenu());
            $view->with('subMenus', $menuService->getSubMenu());
        });
    }
}
