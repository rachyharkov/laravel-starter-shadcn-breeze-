<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuSub;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!request()->inertia() && request()->expectsJson()) {
            if(request()->get('users')) {
                $users = User::with('user_roles:user_id,role_id,is_active')->select('name', 'id');

                return DataTables::of($users)
                    ->editColumn('user_roles', function ($user) {
                        $roles = $user->user_roles;

                        $a = [];
                        // var_dump($roles);
                        foreach ($roles as $key => $value) {
                            $role = Role::find($value->role_id);
                            $a[] = [
                                'name' => $role->name,
                                'color' => $role->color,
                                'is_active' => $value->is_active
                            ];
                        }

                        return $a;
                    })
                    ->toJson();
            }

            if(request()->get('roles')) {
                $roles = Role::all();

                return DataTables::of($roles)
                    ->toJson();
            }

            if(request()->get('menus')) {

                $datas = [];

                $menus = Menu::all();
                $menu_subs = MenuSub::all();

                foreach ($menus as $key => $menu) {
                    if($menu->menu_sub()->count() > 0) {
                        continue;
                    }

                    $datas[] = [
                        'id' => $menu->id,
                        'name' => $menu->name,
                        'icon' => $menu->icon,
                    ];

                    $module_actions = $menu->module_action;

                    foreach ($module_actions as $k => $v) {
                        $datas[] = [
                            'id' => $v->id,
                            'name' => $v->keterangan,
                        ];
                    }
                }

                foreach($menu_subs as $key => $menu_sub) {
                    $datas[] = [
                        'id' => $menu_sub->id,
                        'name' => $menu_sub->name,
                        'icon' => 'lucide:menu',
                    ];

                    $module_actions = $menu_sub->module_action;

                    foreach ($module_actions as $k => $v) {
                        $datas[] = [
                            'id' => $v->id,
                            'name' => $v->keterangan,
                        ];
                    }
                }

                return response()->json($datas);
            }
        }

        return Inertia::render('System/Permissions/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
