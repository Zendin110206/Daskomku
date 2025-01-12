<?php

namespace App\Http\Controllers;

use App\Models\Caas;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Models\CaasStage;
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
                'nim' => $caas->user->nim ?? '',
                'name' => $caas->user->profile->name ?? '',
                'email' => $caas->user->email ?? '', // Assuming 'email' exists in User
                'password' => '', // Avoid passing actual passwords
                'major' => $caas->user->profile->major ?? '',
                'className' => $caas->user->profile->class ?? '',
                'gems' => $caas->role->name ?? '',
                'status' => $caas->user->caasStage->stage_id ?? 'unknown', // Assuming 'status' exists in Caas
                'state' => $caas->user->caasStage->status ?? 'unknown', // Assuming 'state' exists in Caas
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
