<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuSub;
use App\Models\ModuleAction;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name'      => 'Dashboard',
                'route'     => 'dashboard',
                'actions'    => [
                    [
                        'action' => 'index',
                        'keterangan' => 'Lihat Dashboard blablabla'
                    ]
                ],
                'icon'      => 'lucide:chart-area'
            ],
            [
                'name'      => 'Master Data',
                'route'     => 'master-data',
                // 'actions'    => null,
                'icon'      => 'lucide:database',
                'subs' => [
                    [
                        'name'      => 'Peran',
                        'route'     => 'roles',
                        'actions'    => [
                            [
                                'action' => 'index',
                                'keterangan' => 'Lihat Peran List blablabla'
                            ],
                            [
                                'action' => 'create',
                                'keterangan' => 'Buat Peran baru'
                            ],
                            [
                                'action' => 'store',
                                'keterangan' => 'Simpan langsung perna baru'
                            ],
                            [
                                'action' => 'edit',
                                'keterangan' => 'eDIT Peran'
                            ],
                            [
                                'action' => 'update',
                                'keterangan' => 'Update perannya'
                            ],
                            [
                                'action' => 'destroy',
                                'keterangan' => 'hapus perannya'
                            ],
                        ]
                    ],
                    [
                        'name'      => 'Pengguna',
                        'route'     => 'users',
                        'actions'   => [
                            [
                                'action' => 'index',
                                'keterangan' => 'Lihat user List blablabla'
                            ],
                            [
                                'action' => 'create',
                                'keterangan' => 'Buat user baru'
                            ],
                            [
                                'action' => 'store',
                                'keterangan' => 'Simpan langsung user baru'
                            ],
                            [
                                'action' => 'edit',
                                'keterangan' => 'eDIT user'
                            ],
                            [
                                'action' => 'update',
                                'keterangan' => 'Update usernya'
                            ],
                            [
                                'action' => 'destroy',
                                'keterangan' => 'hapus usernya'
                            ],
                        ]
                    ],
                    [
                        'name'      => 'Hak Akses',
                        'route'     => 'accesses',
                        'actions'   => [
                            [
                                'action' => 'index',
                                'keterangan' => 'Lihat daftar hak akses'
                            ],
                            [
                                'action' => 'edit',
                                'keterangan' => 'Edit akses'
                            ],
                            [
                                'action' => 'update',
                                'keterangan' => 'Update akses'
                            ],
                            [
                                'action' => 'destroy',
                                'keterangan' => 'hapus akses'
                            ],
                        ]
                    ],
                ]
            ],
        ];

        foreach ($menus as $km => $m) {
            $menu = Menu::create([
                'position'  => $km + 1,
                'name'      => $m['name'],
                'route'     => $m['route'],
                'icon'      => $m['icon']
            ]);

            if(isset($m['subs'])) {
                foreach ($m['subs'] as $kms => $sub) {
                    $submenu = MenuSub::create([
                        'position' => $kms + 1,
                        'menu_id' => $menu->id,
                        'name'      => $sub['name'],
                        'route'     => $sub['route']
                    ]);

                    if(isset($sub['actions'])) {
                        foreach ($sub['actions'] as $kmss => $value) {
                            ModuleAction::create([
                                'menu_sub_id'   => $submenu->id,
                                'action'    => $value['action'],
                                'keterangan'=> $value['keterangan']
                            ]);
                        }
                    }

                }
            }

            if(isset($m['actions'])) {
                foreach ($m['actions'] as $key => $value) {
                    ModuleAction::create([
                        'menu_id'   => $menu->id,
                        'action'    => $value['action'],
                        'keterangan'=> $value['keterangan']
                    ]);
                }
            }

        }
    }
}
