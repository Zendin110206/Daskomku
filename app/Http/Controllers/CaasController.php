<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaasController extends Controller
{
    public function show()
    {
        // nanti buat halaman caas
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.caas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
