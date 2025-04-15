<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Attendee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendeeTest extends TestCase {
    use RefreshDatabase;

    public function test_attendee_can_be_created() {
        $response = $this->postJson('/api/attendees', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $response->assertStatus(201);
    }

    public function test_attendee_can_be_updated() {
        $attendee = Attendee::factory()->create();

        $response = $this->putJson("/api/attendees/{$attendee->id}", [
            'name' => 'Updated Name'
        ]);

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_attendee_can_be_deleted() {
        $attendee = Attendee::factory()->create();

        $response = $this->deleteJson("/api/attendees/{$attendee->id}");
        $response->assertStatus(204);
    }
}