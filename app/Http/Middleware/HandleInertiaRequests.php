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

        $data_auth_shared = [
            'user' => $request->user(),
            'current_role_session' => $current_role_session,
        ];

        if(isset($current_role_session['id'])) {
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
            };
            foreach ($menu_new as $key => $value) {

                if(count($value->menu_sub) <= 0) {
                    unset($menu_new[$key]->menu_sub);
                }

                if(count($value->module_action) <= 0) {
                    unset($menu_new[$key]->module_action);
                }

            };

            $m = $menu_new->toArray();

            foreach ($m as $key => $value) {
                $m[$key]['is_expanded'] = false;
                if (str_starts_with($request->route()->getName(), $value['route'])) {
                    $m[$key]['is_expanded'] = true;
                }
            }

            // dd($m);

            $data_auth_shared['menu'] = $m;
        }

        // dd($data_auth_shared);
        return [
            ...parent::share($request),
            'auth' => $data_auth_shared,
            'messages' => flash()->render('array'),
        ];
    }
}
