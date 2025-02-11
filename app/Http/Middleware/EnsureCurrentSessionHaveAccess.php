<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\MenuSub;
use App\Models\ModuleAction;
use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EnsureCurrentSessionHaveAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentRoute = $request->route()->getName();
        $exploded_route_string = explode('.', $currentRoute);
        $user = $request->user();

        if ($user->permission_mode === 'role_oriented') {
            $check_what = 'Menu';

            $find = DB::table('menus')
                    ->select('role_permissions.module_action_id', 'role_permissions.id')
                    ->join('module_actions', 'menus.id', '=', 'module_actions.menu_id');

            $cek_1 = $find
                    ->join('role_permissions', 'module_actions.id', '=', 'role_permissions.module_action_id')
                    ->where('menus.route', $exploded_route_string[0])
                    ->where('role_permissions.role_id', session('current_role_session')['id'])
                    // ->where('module_actions.action', 'index')
                    ->first();

            if($cek_1) { //found it!
                return $next($request);
            }

            //null, brarti ada submenunya nih

            $check_what = 'Menu Sub';

            $cek_2 = DB::table('menu_subs')
                ->select('role_permissions.module_action_id', 'role_permissions.id')
                ->join('menus', 'menu_subs.menu_id', '=', 'menus.id')
                ->join('module_actions', 'menu_subs.id', '=', 'module_actions.menu_sub_id')
                ->join('role_permissions', 'module_actions.id', '=', 'role_permissions.module_action_id')
                ->where('role_permissions.role_id', session('current_role_session')['id'])
                ->where('menus.route', $exploded_route_string[0])
                ->where('menu_subs.route', $exploded_route_string[1])
                ->where('module_actions.action', $exploded_route_string[2])
                ->first();

            if($cek_2) { // found it!
                return $next($request);
            }

            return response($check_what.' Module tidak tersedia (NOT ENABLED)', 404);
        }

        return $next($request);
    }
}
