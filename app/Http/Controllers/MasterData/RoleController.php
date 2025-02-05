<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\Role\StoreRoleRequest;
use App\Http\Requests\MasterData\Role\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!request()->inertia() && request()->expectsJson()) {
            $roles = Role::all();

            return DataTables::of($roles)
                ->toJson();
        }

        return Inertia::render('MasterData/Role/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('MasterData/Role/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();

        Role::create($validated);
        session()->flash('success','Peran '.$validated['name'].' berhasil ditambahkan');

        return to_route('master-data.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return Inertia::render('MasterData/Role/Show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return Inertia::render('MasterData/Role/Edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        $role->update($validated);

        $flash = [
            'message' => __('Data berhasil diubah.'),
            'type' => 'success',
        ];

        if (isset($request->save_and_back) && $request->save_and_back == true) {
            return redirect()->back()->with('flash', $flash);
        }

        session()->flash('success','Peran '. $role->name .' berhasil diperbaharui');

        return to_route('master-data.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            session()->flash('success', 'Peran '. $role->name . ' berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus peran: ' . $e->getMessage());
        }

        return to_route('master-data.roles.index');
    }
}
