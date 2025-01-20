<?php

namespace App\Http\Middleware;

use App\Models\MenuAccessRight;
use App\Models\Role;
use Illuminate\Http\Request;
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
        $current_role_session = $request->session()->get('current_role_session');

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'current_role_session' => $current_role_session,
                'menu_access_right' => $current_role_session ? MenuAccessRight::with(['menu', 'menu_sub_access_right.menu_sub'])->where('role_id', $current_role_session['id'])->get() : null
            ],
            'messages' => flash()->render('array'),
        ];
    }
}
