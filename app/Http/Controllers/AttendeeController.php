<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;

class AttendeeController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:attendees,email'
        ]);
        
        return Attendee::create($validated);
    }

    public function update(Request $request, $id) {
        $attendee = Attendee::findOrFail($id);
        $attendee->update($request->all());
        return $attendee;
    }

    public function destroy($id) {
        Attendee::destroy($id);
        return response(null, 204);
    }
}