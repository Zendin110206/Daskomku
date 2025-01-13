<?php

namespace App\Http\Controllers;

use App\Models\Caas;
use App\Models\Role;
use App\Models\Stage;
use Illuminate\Http\Request;

class UserCaasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'nim' => 'required|string|max:12',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'className' => 'nullable|string|max:255',
            'gems' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
        ]);

        // Find the Caas record by ID
        $caas = Caas::with(['user.profile', 'role', 'user.caasStage'])->findOrFail($id);

        // Update User details
        $caas->user->update([
            'nim' => $validated['nim'],
        ]);
        
        // Update Profile details
        $caas->user->profile()->updateOrCreate(
            ['user_id' => $caas->user->id],
            [
                'name' => $validated['name'],
                'major' => $validated['major'],
                'class' => $validated['className'],
                'email' => $validated['email'],
            ]
        );

        // Update Role details
        $role = Role::firstOrCreate(['name' => $validated['gems']]);
        $caas->update(['role_id' => $role->id]);

        $stage = Stage::where('name', $request->state)->first();

        if (!$stage) {
            // Handle case where the Stage doesn't exist
            return response()->json(['error' => 'Invalid stage name provided'], 422);
        }
        // Update CaasStage details
        $caas->user->caasStage()->updateOrCreate(
            ['user_id' => $caas->user->id],
            [
                'status' => $validated['status'],
                'stage_id' => $stage->id,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
