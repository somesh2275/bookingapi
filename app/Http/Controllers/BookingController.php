<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;

class BookingController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendee_id' => 'required|exists:attendees,id',
        ]);

        $event = Event::findOrFail($request->event_id);
        $alreadyBooked = Booking::where('event_id', $event->id)
                                ->where('attendee_id', $request->attendee_id)
                                ->exists();

        if ($alreadyBooked) {
            return response()->json(['error' => 'Already booked'], 422);
        }

        if ($event->bookings()->count() >= $event->capacity) {
            return response()->json(['error' => 'Event is full'], 422);
        }

        $booking = Booking::create($request->only(['event_id', 'attendee_id']));
        return response()->json($booking, 201);
    }

    public function destroy($id) {
        Booking::destroy($id);
        return response(null, 204);
    }
}