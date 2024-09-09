<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class roleTest extends TestCase
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
    public function it_can_create_a_role()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/roles', [
                'name' => 'Admin',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Role created successfully',
                'role' => [
                    'name' => 'Admin',
                ],
            ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'Admin',
        ]);
    }

    /** @test */
    public function it_can_read_a_role()
    {
        $role = Role::factory()->create([
            'name' => 'User',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/roles/' . $role->id);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'User',
            ]);
    }

    /** @test */
    public function it_can_update_a_role()
    {
        $role = Role::factory()->create([
            'name' => 'User',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson('/api/roles/' . $role->id, [
                'name' => 'Super User',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Role updated successfully',
                'role' => [
                    'name' => 'Super User',
                ],
            ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'Super User',
        ]);
    }

    /** @test */
    public function it_can_delete_a_role()
    {
        $role = Role::factory()->create([
            'name' => 'User',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson('/api/roles/' . $role->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Role deleted successfully',
            ]);

        $this->assertDatabaseMissing('roles', [
            'name' => 'User',
        ]);
    }
}
