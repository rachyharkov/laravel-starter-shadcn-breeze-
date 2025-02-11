<?php

namespace App\Http\Middleware;

use App\Models\Menu;
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
                'menu' => Menu::with('menu_sub')->get()->toArray() //TODO: Filter the data based on permission
            ],
            'messages' => flash()->render('array'),
        ];
    }
}
