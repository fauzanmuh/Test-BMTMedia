<?php

namespace Tests\Feature;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class userTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->token = $response->json('token');
    }

    /** @test */
    public function it_can_create_a_user()
    {

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/users', [
                'name' => 'Fauzan',
                'email' => 'fauzan@gmail.com',
                'password' => 'password',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User created successfully',
                'user' => [
                    'name' => 'Fauzan',
                    'email' => 'fauzan@gmail.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'fauzan@gmail.com',
        ]);
    }

    /** @test */
    public function it_can_read_a_user()
    {
        $user = User::factory()->create([
            'name' => 'Marteen Paes',
            'email' => 'marteen@paes.com',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/users/' . $user->id);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Marteen Paes',
                'email' => 'marteen@paes.com',
            ]);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create([
            'name' => 'Fauzan',
            'email' => 'fauzan@gmail.com',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson('/api/users/' . $user->id, [
                'name' => 'M Fauzan',
                'email' => 'fauzan@gmail.com',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User updated successfully',
                'user' => [
                    'name' => 'M Fauzan',
                    'email' => 'fauzan@gmail.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'M Fauzan',
            'email' => 'fauzan@gmail.com',
        ]);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create([
            'name' => 'M Fauzan',
            'email' => 'fauzan@gmail.com',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User deleted successfully',
            ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'fauzan@gmail.com',
        ]);
    }
}
