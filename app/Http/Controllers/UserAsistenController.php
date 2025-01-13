<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAsistenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('profile')
            ->where('is_admin', 1) // Filter users with is_admin = 1
            ->where('id', '!=', Auth::user()->id) // Exclude the specific user
            ->get();

        // Map data to match the desired structure
        $asistenList = $users->map(function ($user) {
            return [
                'id' => $user->id, // Assuming this is the User ID
                'kodeAsisten' => $user->nim ?? '',
                'nama_lengkap' => $user->profile->name ?? '',
                'divisi' => $user->profile->major ?? '',
            ];
        });

        return view('admin.asisten', ['asistenList' => $asistenList]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kodeAsisten' => 'required|string|max:12',
            'password' => 'required|string|max:255',
            'namaLengkap' => 'nullable|string|max:255',
            'divisi' => 'nullable|string|max:255',
        ]);

        try {
            $user = User::create([
                'nim' => $validated['kodeAsisten'],
                'password' => bcrypt($validated['password']),
                'is_admin' => 1,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'That kodeAsisten cannot be used.'], 409);
        }

        $user->profile()->create([
            'name' => $validated['namaLengkap'],
            'major' => $validated['divisi'],
        ]);

        return response()->json(['success' => 'Successfully created new Asisten'], 201);
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

                $user = User::findOrFail($id);
                $user->update([
                    'password' => bcrypt($validated['setPass']),
                ]);

                return response()->json(['message' => 'Password updated successfully.'], 200);
            } else {
                // Handle the case where 'set_pass' is empty
                return response()->json(['error' => 'Password cannot be empty.'], 422);
            }
        }

        $validated = $request->validate([
            'kodeAsisten' => 'required|string|max:12',
            'namaLengkap' => 'nullable|string|max:255',
            'divisi' => 'nullable|string|max:255',
        ]);

        $user = User::with('profile')->findOrFail($id);

        try {
            $user->update([
                'nim' => $validated['kodeAsisten'],
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'That kodeAsisten cannot be used.'], 409);
        }
        
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $validated['namaLengkap'],
                'major' => $validated['divisi'],
            ]
        );

        return response()->json(['success' => 'Successfully updated asisten'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
    }
}
