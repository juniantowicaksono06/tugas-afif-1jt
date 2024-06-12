<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class MasterMenuSeeder01 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    /**
     * Run the database seeds.
     */
        //
        $listMenu = [
            'Beranda'   => [
                'id'        => Uuid::uuid4()->toString(),
                'icon'      => 'fa fa-home',
                'link'      => '/',
                'subMenu'   => []
            ],
            'Logout'    => [
                'id'        => Uuid::uuid4()->toString(),
                'icon'      => 'fa fa-door-open',
                'link'      => '/logout',
                'subMenu'   => []
            ],
            'Presensi'  => [
                'id'        => Uuid::uuid4()->toString(),
                'icon'      => 'fa fa-clock',
                'link'      => '#',
                'subMenu'   => [
                    'Presensi'  => [
                        'id'    => Uuid::uuid4()->toString(),
                        'icon'  => 'far fa-clock nav-icon',
                        'link'  => '/presensi/check-in'
                    ],
                    'Riwayat Presensi' => [
                        'id'    => Uuid::uuid4()->toString(),
                        'icon'  => 'far fa-address-book nav-icon',
                        'link'  => '/presensi/riwayat'
                    ]
                ]
            ]
        ];
        $data = [];
        foreach($listMenu as $menuName => $menu) {
            array_push($data, [
                'menuID'    => $menu['id'],
                'name'      => $menuName,
                'link'      => $menu['link'],
                'icon'      => $menu['icon'],
                'isParent'  => 1,
                'hasChild'  => count($menu['subMenu']) > 0 ? 1 : 0,
                'parentID'  => $menu['id']
            ]);
            if(count($menu['subMenu']) > 0) {
                foreach($menu['subMenu'] as $subMenuName => $subMenu) {
                    array_push($data, [
                        'menuID'    => $subMenu['id'],
                        'name'      => $subMenuName,
                        'link'      => $subMenu['link'],
                        'icon'      => "",
                        'isParent'  => 0,
                        'hasChild'  => 0,
                        'parentID'  => $menu['id']
                    ]);
                }
            }
        }
        \DB::table('MasterMenu')->insert($data);
    }
}