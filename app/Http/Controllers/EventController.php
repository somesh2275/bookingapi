<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index() {
        return Event::paginate(10);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'capacity' => 'required|integer|min:1',
            'country' => 'required|string'
        ]);

        return Event::create($validated);
    }

    public function show($id) {
        return Event::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        
        return $event;
    }

    public function destroy($id) {
        Event::destroy($id);
        return response(null, 204);
    }
}