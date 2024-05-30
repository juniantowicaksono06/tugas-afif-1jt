<?php

namespace App\Services;

use App\Models\MasterMenu;

class MenuService
{
    public function getMenu()
    {
        return MasterMenu::where('isParent', 1)
                    ->get();
    }

    public function getSubMenu() {
        $menus = MasterMenu::where('isParent', 1)
        ->where('hasChild', 1)
        ->get();
        $data = [];
        foreach($menus as $menu) {
            $subMenu = MasterMenu::where('isParent', 0)
            ->where('hasChild', 0)
            ->where('parentID', $menu->menuID)
            ->get()->toArray();
            $data[$menu->menuID]   = $subMenu;
        }
        return $data;
    }
}
