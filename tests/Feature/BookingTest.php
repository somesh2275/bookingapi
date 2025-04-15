<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase {
    use RefreshDatabase;

    public function test_booking_can_be_created() {
        $event = Event::factory()->create(['capacity' => 1]);
        $attendee = Attendee::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id
        ]);

        $response->assertStatus(201);
    }

    public function test_duplicate_booking_is_prevented() {
        $event = Event::factory()->create(['capacity' => 1]);
        $attendee = Attendee::factory()->create();

        $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id
        ]);

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id
        ]);

        $response->assertStatus(422);
    }

    public function test_overbooking_is_prevented() {
        $event = Event::factory()->create(['capacity' => 1]);
        $attendee1 = Attendee::factory()->create();
        $attendee2 = Attendee::factory()->create();

        $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee1->id
        ]);

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee2->id
        ]);

        $response->assertStatus(422);
    }

    public function test_booking_can_be_deleted() {
        $event = Event::factory()->create();
        $attendee = Attendee::factory()->create();
        $booking = $event->bookings()->create(['attendee_id' => $attendee->id]);

        $response = $this->deleteJson("/api/bookings/{$booking->id}");
        $response->assertStatus(204);
    }
}