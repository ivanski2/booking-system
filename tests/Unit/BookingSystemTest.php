<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingSystemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login functionality.
     */
    public function test_user_can_login()
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'ivanski34@gmail.com',
            'password' => bcrypt('ivanpass'),
        ]);

        // Simulate login request
        $response = $this->postJson('/api/login', [
            'email' => 'ivanski34@gmail.com',
            'password' => 'ivanpass',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'expires_at']);
    }

}
