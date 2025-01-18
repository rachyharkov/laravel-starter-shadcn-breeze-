<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected string $avatarPath = 'uploads/images/avatars/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!request()->inertia() && request()->expectsJson()) {
            $users = User::with('user_roles:user_id,role_id,is_active');

            return Datatables::of($users)
                ->editColumn('user_roles', function ($user) {
                    $roles = $user->user_roles;

                    $a = [];
                    // var_dump($roles);
                    foreach ($roles as $key => $value) {
                        $a[] = [
                            'name' => Role::find($value->role_id)->name,
                            'is_active' => $value->is_active
                        ];
                    }

                    return $a;
                })
                ->addColumn('action', 'users.include.action')
                ->addColumn('avatar', function ($row) {
                    if ($row->avatar == null) {
                        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($row->email))) . '&s=500';
                    }
                    return $row->avatar;
                })
                ->toJson();
        }

        return Inertia::render('Users/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return Inertia::render('Users/Create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        // sementara role & branch dibuat null dulu
        // unset($validated['password_confirmation'], $validated['role_id'], $validated['branch_id']);
        unset($validated['password_confirmation']);

        if ($request->file('avatar') && $request->file('avatar')->isValid()) {

            $filename = $request->file('avatar')->hashName();

            if (!Storage::disk('public')->exists($this->avatarPath)) {
                Storage::disk('public')->makeDirectory($this->avatarPath);
            }

            Image::read($request->file('avatar')
                ->getRealPath())
                ->scale(500)
                ->save(storage_path('app/public/' . $this->avatarPath . $filename));

            $validated['avatar'] = $filename;
        }

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        if (isset($validated['role_id'])) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $validated['role_id'],
                'is_active' => $validated['is_active']
            ]);
        }

        session()->flash('success','Pengguna '.$user->name.' berhasil ditambahkan');

        return to_route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Inertia::render('Users/Show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load('user_roles.role:id,name');
        $user->role_id      = isset($user->user_roles[0]->role_id) ? $user->user_roles[0]->role_id : '';
        $user->is_active    = $user->user_roles[0]->is_active;

        $roles = Role::all();

        return Inertia::render('Users/Edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // dd($validated);

        // sementara role & branch dibuat null dulu
        unset($validated['password_confirmation'], $validated['branch_id']);

        if ($request->file('avatar') && $request->file('avatar')->isValid()) {
            $filename = $request->file('avatar')->hashName();

            if (!Storage::disk('public')->exists($this->avatarPath)) {
                Storage::disk('public')->makeDirectory($this->avatarPath);
            }

            Image::read($request->file('avatar')
                ->getRealPath())
                ->scale(500)
                ->save(storage_path('app/public/' . $this->avatarPath . $filename));

            if (
                $user->avatar != null &&
                Storage::disk('public')->exists($oldAvatar = $this->avatarPath . basename($user->avatar))
            ) {
                Storage::disk('public')->delete($oldAvatar);
            }

            $validated['avatar'] = $filename;
        }

        if ($request->password != null) {
            $validated['password'] = bcrypt($request->password);
        } else {
            $validated['password'] = $user->password;
        }

        $user->update($validated);

        UserRole::where('user_id', $user->id)->delete();

        if (isset($validated['role_id'])) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $validated['role_id'],
                'is_active' => $validated['is_active']
            ]);
        }

        $flash = [
            'message' => __('Data berhasil diubah.'),
            'type' => 'success',
        ];

        if (isset($request->save_and_back) && $request->save_and_back == true) {
            return redirect()->back()->with('flash', $flash);
        }

        session()->flash('success','Data pengguna '. $user->name .' berhasil diperbaharui');

        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (
            $user->avatar != null &&
            Storage::disk('public')->exists($oldAvatar = $this->avatarPath . basename($user->avatar))
        ) {
            Storage::disk('public')->delete($oldAvatar);
        }

        $user->delete();

        UserRole::where('user_id', $user->id)->delete();

        session()->flash('success', 'Pengguna '. $user->name . ' berhasil dihapus');

        return to_route('users.index');
    }
}
