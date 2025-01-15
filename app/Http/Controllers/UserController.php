<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected string $avatarPath = 'public/uploads/images/avatars/';
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
                    return asset($this->avatarPath . $row->avatar);
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
        $roles = UserRole::with('roles');

        return Inertia::render('Users/Create', $roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        // sementara role & branch dibuat null dulu
        // unset($validated['password_confirmation'], $validated['role_id'], $validated['branch_id']);
        unset($validated['password_confirmation'], $validated['role_id']);

        if ($request->file('avatar') && $request->file('avatar')->isValid()) {

            $filename = $request->file('avatar')->hashName();

            if (!Storage::disk('local')->exists($this->avatarPath)) {
                Storage::disk('local')->makeDirectory($this->avatarPath);
            }

            Image::make($request->file('avatar')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/' . $this->avatarPath . $filename));

            $validated['avatar'] = $filename;
        }

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        if (isset($validated['role_id'])) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $validated['role_id']
            ]);
        }

        flash()->success('Data berhasil ditambahkan');

        return redirect('users.index');
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
        $user->load('roles:id,name');
        $user->role_id = isset($user->roles[0]) ? $user->roles[0]->id : '';

        $roles = Role::all();

        return Inertia::render('Users/Edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validated();

        // sementara role & branch dibuat null dulu
        unset($validated['password_confirmation'], $validated['branch_id']);

        if ($request->file('avatar') && $request->file('avatar')->isValid()) {
            $filename = $request->file('avatar')->hashName();

            if (!Storage::disk('local')->exists($this->avatarPath)) {
                Storage::disk('local')->makeDirectory($this->avatarPath);
            }

            Image::read($request->file('avatar')->getRealPath())
                ->resize(500, 500)
                ->save(storage_path('app/' . $this->avatarPath . $filename));

            if ($user->avatar != null && Storage::disk('local')->exists($oldAvatar = $this->avatarPath . $user->avatar)) {
                Storage::disk('local')->delete($oldAvatar);
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
            'role_id' => $validated['role_id']
            ]);
        }

        $flash = [
            'message' => __('Data berhasil diubah.'),
            'type' => 'success',
        ];

        if (isset($request->save_and_back) && $request->save_and_back == true) {
            return redirect()->back()->with('flash', $flash);
        }

        flash()->success('Data berhasil diubah');

        return redirect('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->avatar != null && Storage::disk('local')->exists($oldAvatar = $this->avatarPath . $user->avatar)) {
            Storage::disk('local')->delete($oldAvatar);
        }

        $user->delete();

        UserRole::where('user_id', $user->id)->delete();

        flash()->success('Data berhasil dihapus');

        return to_route('users.index', [], 303);
    }
}
