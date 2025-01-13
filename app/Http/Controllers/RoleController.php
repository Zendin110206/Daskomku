<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $rolesList = $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'quota' => $role->quota ?? 0,
                'image' => $role->avatar_url ?? '',
                'description' => $role->description ?? '',
            ];
        });
        return view('admin.gems', ['rolesList' => $rolesList]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'quota' => 'nullable|int|max:255',
            'avatar_url' => 'nullable|string|max:255',
        ]);

        Role::create($validated);

        return response()->json(['success' => 'Successfully created new gem'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'quota' => 'nullable|int|max:255',
            'avatar_url' => 'nullable|string|max:255',
        ]);

        Role::findOrFail($id)->update($validated);

        return response()->json(['success' => 'Successfully updated gem'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::destroy($id);
    }
}
