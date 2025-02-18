<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $authenticated_user = Auth::user();

        $role_active = UserRole::with('role')->where('user_id', $authenticated_user->id)->where('is_active', 1);

        if($role_active->doesntExist()) {
            Auth::guard('web')->logout();
            return redirect()->back()->withErrors(['email' => 'Akun anda tidak aktif, silahkan hubungi admin']);
        }

        $request->session()->regenerate();

        $first_role_active = $role_active->first();

        $request->session()->put('current_role_session', [
            'id' => $first_role_active->role_id,
            'name' => $first_role_active->role->name
        ]);

        return redirect()->intended(route('dashboard.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
