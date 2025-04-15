<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase {
    use RefreshDatabase;

    protected function authenticate() {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_event_can_be_created() {
        $headers = $this->authenticate();

        $response = $this->postJson('/api/events', [
            'name' => 'Sample Event',
            'description' => 'Description',
            'date' => '2025-06-01',
            'capacity' => 100,
            'country' => 'USA'
        ], $headers);

        $response->assertStatus(201);
    }

    public function test_event_can_be_listed() {
        $headers = $this->authenticate();
        Event::factory()->count(3)->create();

        $response = $this->getJson('/api/events', $headers);
        $response->assertStatus(200);
    }

    public function test_event_can_be_updated() {
        $headers = $this->authenticate();
        $event = Event::factory()->create();

        $response = $this->putJson("/api/events/{$event->id}", [
            'name' => 'Updated Name'
        ], $headers);

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_event_can_be_deleted() {
        $headers = $this->authenticate();
        $event = Event::factory()->create();

        $response = $this->deleteJson("/api/events/{$event->id}", [], $headers);
        $response->assertStatus(204);
    }
}