<?php

namespace Database\Seeders;

use App\Models\MenuAccessRight;
use App\Models\MenuSubAccessRight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuAccessRightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $akses_role = [
            1 => [
                'menus' => [
                    [
                        'id' => 1
                    ],
                    [
                        'id' => 2,
                        'submenus' => [1,2]
                    ]
                ]
            ],
            2 => [
                'menus' => [
                    [
                        'id' => 1
                    ]
                ]
            ]
        ];

        foreach ($akses_role as $role_id => $value) {
            foreach ($value['menus'] as $k => $v) {
                $menuaccessright = MenuAccessRight::create([
                    'role_id' => $role_id,
                    'menu_id' => $v['id']
                ]);

                if(isset($v['submenus'])) {
                    foreach ($v['submenus'] as $kk => $vv) {
                        MenuSubAccessRight::create([
                            'role_id' => $role_id,
                            'menu_access_right_id' => $menuaccessright->id,
                            'menu_sub_id' => $vv
                        ]);
                    }
                }
            }

        }
    }
}
