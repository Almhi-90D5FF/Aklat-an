<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Models\Section;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservations::all();
        return view('reservations.index', compact('reservations')); 
    }

    /**
     * Show ALL reservations of the logged-in user
     */
    public function myBookings()
    {
            $reservations = Reservations::where('user_id', auth()->id())
                ->with('section')
                ->latest()
                ->get();

            return view('reservations.my-bookings', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Section $section)
    {
        return view('reservations.create', compact('section'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Section $section)
    {

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required',
            'purpose' => 'required',
            'resource_details' => 'nullable|string',
            'usage_details' => 'nullable|string',
        ]);

        Reservations::create([
            'user_id' => auth()->id(),
            'section_id' => $section->id,
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'purpose' => $request->purpose,
            'resource_details' => $request->resource_details,
            'usage_details' => $request->usage_details,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('my-bookings')
            ->with('success', 'Your appointment was successfully created.');

    }

    /**
     * Add reservation to Google Calendar
     */
    public function addToCalendar(Reservations $reservation)
    {
        abort_unless($reservation->user_id === auth()->id(), 403);

        $start = \Carbon\Carbon::parse($reservation->date . ' ' . explode('-', $reservation->time_slot)[0]);
        $end = \Carbon\Carbon::parse($reservation->date . ' ' . explode('-', $reservation->time_slot)[1]);

        $query = http_build_query([
            'action' => 'TEMPLATE',
            'text' => 'Library Reservation - ' . $reservation->section->name,
            'dates' => $start->format('Ymd\THis') . '/' . $end->format('Ymd\THis'),
            'details' => $reservation->purpose,
            'location' => $reservation->section->name,
        ]);

        return redirect('https://calendar.google.com/calendar/render?' . $query);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservations $reservations)
    {
        // Security check
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservations $reservations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservations $reservations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservations $reservations)
    {
        //
    }

    /**
     * Cancel a reservation.
     */
    public function cancel(Request $request, Reservations $reservation)
    {
        if (strtolower($reservation->status) === 'approved') {
            $request->validate([
                'cancel_reason' => 'required|string|min:3',
            ]);
            $reservation->cancel_reason = $request->cancel_reason;
        }

        $reservation->status = 'Cancelled';
        $reservation->save();

        return back()->with('success', 'Appointment cancelled.');
    }

}
