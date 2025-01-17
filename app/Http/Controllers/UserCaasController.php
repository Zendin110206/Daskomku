<?php
// app/Http/Contollers/UserCaasController.php

namespace App\Http\Controllers;

use App\Models\Caas;
use App\Models\Role;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Http\Request;

class UserCaasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userCount = User::where('is_admin', 0)->count();
        $caasCount = Caas::count();

        if ($caasCount !== $userCount) { // in case Caas is empty somehow???
            $users = User::with(['profile', 'caasStage', 'caas'])->where('is_admin', 0)->get();
            foreach ($users as $user) {
                // Skip users who already have a Caas record
                if ($user->caas) {
                    continue;
                }

                // Assign a role to the user
                $role = Role::firstOrCreate(
                    ['name' => 'Default Role'], // Example role name
                    ['description' => 'Default role for new CAAS users.']
                );

                // Create the Caas record
                Caas::create([
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                ]);
            }
        }
        // Fetch all Caas with their related User, Profile, and Role
        $caas = Caas::with(['user.profile', 'user.caasStage', 'role'])->get();
        // Map data to match the desired structure
        $caasList = $caas->map(function ($caas) {
            return [
                'id' => $caas->id,
                'nim' => $caas->user->nim ?? '',
                'name' => $caas->user->profile->name ?? '',
                'email' => $caas->user->profile->email ?? '',
                'major' => $caas->user->profile->major ?? '',
                'className' => $caas->user->profile->class ?? '',
                'gems' => $caas->role->name ?? '',
                'state' => $caas->user->caasStage->stage->name ?? 'unknown',
                'status' => $caas->user->caasStage->status ?? 'unknown',
            ];
        });

        // Pass the data to the view
        return view('admin.caas', ['caasList' => $caasList]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:12',
            'password' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'className' => 'nullable|string|max:255',
            // 'gems' => 'nullable|string|max:255',         // Hapus 'gems' dan 'status' karena kita isi otomatis
            // 'status' => 'nullable|string|max:255',
            // 'state' => 'nullable|string|max:255',
        ]);

        try {
            $user = User::create([
                'nim' => $validated['nim'],
                'password' => bcrypt($validated['password']),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'That NIM already exists.'], 409);
        }

        $user->profile()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'major' => $validated['major'],
            'class' => $validated['className'],
        ]);

        $role = Role::firstOrCreate(['name' => 'No Gems']);

        Caas::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        // Default Stage => "Administration"
        $stage = Stage::firstOrCreate(['name' => 'Administration']);
        // Atau jika user boleh mengirim state dari FE:
        // $stageName = $request->input('state', 'Administration');
        // $stage = Stage::firstOrCreate(['name' => $stageName]);

        // Default status => "unknown"
        $user->caasStage()->create([
            'stage_id' => $stage->id,
            'status'   => 'unknown',
        ]);

        return response()->json(['success' => 'Successfully created new CaAs'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->has('setPass')) {
            if ($request->filled('setPass')) {
                $validated = $request->validate([
                    'setPass' => 'required|string|max:255'
                ]);

                $caas = Caas::with(['user'])->findOrFail($id);
                $caas->user->update([
                    'password' => bcrypt($validated['setPass']),
                ]);

                return response()->json(['message' => 'Password updated successfully.'], 200);
            } else {
                // Handle the case where 'set_pass' is empty
                return response()->json(['error' => 'Password cannot be empty.'], 422);
            }
        }

        $validated = $request->validate([
            // 'nim' => 'required|string|max:12', // kan gak bisa edit nim di frontend admin
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'className' => 'nullable|string|max:255',
            'gems' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
        ]);

        $caas = Caas::with(['user.profile', 'role', 'user.caasStage'])->findOrFail($id);

        // $caas->user->update([
        //     'nim' => $validated['nim'],
        // ]);

        $caas->user->profile()->updateOrCreate(
            ['user_id' => $caas->user->id],
            [
                'name' => $validated['name'],
                'major' => $validated['major'],
                'class' => $validated['className'],
                'email' => $validated['email'],
            ]
        );

        $role = Role::firstOrCreate(['name' => $validated['gems']]);
        $caas->update(['role_id' => $role->id]);

        $stage = Stage::firstOrCreate(
            ['name' => $validated['state']], // Search condition
            ['name' => $validated['state']] // Values to insert if not found
        );

        $caas->user->caasStage()->updateOrCreate(
            ['user_id' => $caas->user->id],
            [
                'status' => $validated['status'],
                'stage_id' => $stage->id,
            ]
        );

        return response()->json(['success' => 'Successfully updated CaAs'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Caas::destroy($id);
    }
}
