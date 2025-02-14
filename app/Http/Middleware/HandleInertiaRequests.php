<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $current_role_session = session('current_role_session');

        $menu = Menu::with([
            'menu_sub.module_action' => function ($q) use ($current_role_session) {
                $q->leftJoin('role_permissions', 'module_actions.id', '=', 'role_permissions.module_action_id');
                $q->where('action', 'index');
                $q->where('role_id', $current_role_session['id']);
            },
            'module_action' => function ($q) use ($current_role_session) {
                $q->leftJoin('role_permissions', 'module_actions.id', '=', 'role_permissions.module_action_id');
                $q->where('action', 'index');
                $q->where('role_id', $current_role_session['id']);
            }])
            ->get();

        $menu_new = $menu->map(function($item) {
            foreach ($item->menu_sub as $k => $v) {
                if(count($v->module_action) <= 0) {
                    unset($item->menu_sub[$k]);
                }
            }
            return $item;
        });

        foreach ($menu_new as $key => $value) {
            if((count($value->menu_sub) <= 0) && count($value->module_action) <= 0) {
                unset($menu_new[$key]);
            }
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'current_role_session' => $current_role_session,
                'menu' => $menu_new
            ],
            'messages' => flash()->render('array'),
        ];
    }
}
