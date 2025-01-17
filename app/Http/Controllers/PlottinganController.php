<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plottingan;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;
use App\Models\Caas;

class PlottinganController extends Controller
{
    // ================ PICK SHIFT (CAAS) ================
    public function pickShift(Request $request)
    {
        $request->validate([
            'shift_id' => 'required|exists:shifts,id',
        ]);

        $caasId = Auth::id();

        $shift = Shift::findOrFail($request->shift_id);

        // Cek kuota
        $alreadyPickedCount = Plottingan::where('shift_id', $shift->id)->count();
        if ($alreadyPickedCount >= $shift->kuota) {
            return back()->with('error', 'Shift is full. Quota exceeded!');
        }

        // Cek overlap
        $isOverlap = Plottingan::join('shifts', 'plottingans.shift_id', '=', 'shifts.id')
            ->where('plottingans.caas_id', $caasId)
            ->whereDate('shifts.date', $shift->date)
            ->where(function($query) use ($shift) {
                $query->whereBetween('shifts.time_start', [$shift->time_start, $shift->time_end])
                      ->orWhereBetween('shifts.time_end',   [$shift->time_start, $shift->time_end]);
            })
            ->exists();

        if ($isOverlap) {
            return back()->with('error', 'You already picked a shift that overlaps with this time!');
        }

        // Simpan Plot
        Plottingan::create([
            'caas_id'  => $caasId,
            'shift_id' => $shift->id,
        ]);

        return back()->with('success', 'Shift picked successfully!');
    }

    // ================ VIEW PLOT ================
    public function viewPlot()
    {
        $shifts = Shift::withCount('plottingans')
            ->orderBy('date', 'asc')
            ->orderBy('time_start', 'asc')
            ->get();

        $totalShifts = $shifts->count();
        $takenShifts = $shifts->sum('plottingans_count');

        $totalCaas    = Caas::count();
        $havenTPicked = $totalCaas - $takenShifts; 
        // definisi "haven't picked" menyesuaikan aturan Anda

        return view('admin.view-plot', compact('shifts', 'totalShifts', 'takenShifts', 'havenTPicked'));
    }

    // ================ DETAIL SHIFT ================
    public function show($id)
    {
        $shift = Shift::with('plottingans.caas')->findOrFail($id);
        return view('admin.view-plot-show', compact('shift'));
    }
}
