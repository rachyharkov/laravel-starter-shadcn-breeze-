<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\MenuAccessRight;
use App\Models\MenuSub;
use App\Models\MenuSubAccessRight;
use Closure;
use Illuminate\Http\Request;
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
        // dd($currentRoute);

        $check_access_menu = MenuAccessRight::with([
                'menu' => function ($query) use ($currentRoute) {
                    if($query->where('route', $currentRoute)->exists()) {
                        return $query;
                    }

                    if(str_contains($currentRoute, '.')) {
                        if($query->where('route', explode('.',$currentRoute)[0])->exists()) {
                            return $query;
                        }
                    }

                    return null;
                }
            ])
            ->where('role_id', session('current_role_session')['id']);

        if (!$check_access_menu->exists()) {
            return response('Access denied (Menu)', 403);
        }

        // dd($currentRoute);

        // if(MenuSubAccessRight::where('menu_access_right_id', $check_access_menu->first()->id)->exists()) {

        if(str_contains($currentRoute, '.')) {
            $secondRoutePart = explode('.', $currentRoute)[1];

            $check_access_menu_sub = MenuSubAccessRight::with([
                    'sub_menu' => function ($query) use ($secondRoutePart) {
                        if(!$query->where('route', $secondRoutePart)->exists()) {
                            return false;
                        }
                    }
                ])
                ->where('role_id', session('current_role_session')['id']);

            if (!$check_access_menu_sub->exists()) {
                return response('Access denied (Sub Menu)', 403);
            }
        }

        return $next($request);
    }
}
