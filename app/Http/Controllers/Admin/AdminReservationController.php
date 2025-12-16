<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservations;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservations::with(['user', 'section'])
            ->latest()
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function updateStatus(Request $request, Reservations $reservation)
    {
        $request->validate([
            'status' => 'required|in:approved,disapproved,no_show',
        ]);

        $reservation->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status updated.');
    }
}
