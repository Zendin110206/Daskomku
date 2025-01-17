<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Plottingan;
use Carbon\Carbon;

class ShiftController extends Controller
{
    /**
     * Menampilkan list shift (untuk admin).
     * Misal ini correspond ke halaman resources/views/admin/shift.blade.php
     */
    public function index()
    {
        // Ambil semua shift atau bisa diurutkan misalnya by date ASC
        $shifts = Shift::orderBy('date', 'asc')
            ->orderBy('time_start', 'asc')
            ->get();

        // Return ke view (untuk contoh: 'admin.shift')
        // Atau kalau Anda masih pakai data dummy di JS, 
        // Anda bisa return data JSON dulu untuk Alpine.js
        return view('admin.shift', compact('shifts'));
    }

    /**
     * Simpan SHIFT baru.
     * (Correspond ke aksi Add Shift)
     */
    public function store(Request $request)
    {
        $request->validate([
            'shift_no'   => 'required|string|max:50',
            'date'       => 'required|date',
            'time_start' => 'required',
            'time_end'   => 'required',
            'kuota'      => 'required|integer|min:0',
        ]);

        Shift::create([
            'shift_no'   => $request->shift_no,
            'date'       => $request->date,
            'time_start' => $request->time_start,
            'time_end'   => $request->time_end,
            'kuota'      => $request->kuota,
        ]);

        return redirect()->back()->with('success', 'Shift created successfully!');
    }

    /**
     * Menampilkan detail SHIFT tertentu (View Shift).
     */
    public function show($id)
    {
        $shift = Shift::findOrFail($id);
        return view('admin.shift-show', compact('shift'));
    }

    /**
     * Update SHIFT (Edit Shift).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'shift_no'   => 'required|string|max:50',
            'date'       => 'required|date',
            'time_start' => 'required',
            'time_end'   => 'required',
            'kuota'      => 'required|integer|min:0',
        ]);

        $shift = Shift::findOrFail($id);
        $shift->update([
            'shift_no'   => $request->shift_no,
            'date'       => $request->date,
            'time_start' => $request->time_start,
            'time_end'   => $request->time_end,
            'kuota'      => $request->kuota,
        ]);

        return redirect()->back()->with('success', 'Shift updated successfully!');
    }

    /**
     * Hapus SHIFT (Delete).
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->delete();

        // Jika Anda ingin menghapus data Plottingan yang terikat ke shift ini:
        // Plottingan::where('shift_id', $id)->delete();

        return redirect()->back()->with('success', 'Shift deleted successfully!');
    }

    /**
     * RESET SHIFT: hapus semua data SHIFT (dan Plottingan jika diperlukan).
     */
    public function resetShifts()
    {
        // Hapus seluruh SHIFT
        Shift::truncate();

        // Jika mau hapus juga data Plottingan / penjadwalan
        // Plottingan::truncate();

        return redirect()->back()->with('success', 'All Shifts have been reset!');
    }

    /**
     * RESET PLOT: hapus data Plottingan (assign shift).
     */
    public function resetPlot()
    {
        Plottingan::truncate();

        return redirect()->back()->with('success', 'All Plots have been reset!');
    }
}
