<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class postsTest extends TestCase
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
    public function it_can_create_a_post()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/posts', [
                'title' => 'New Post Title',
                'content' => 'Indonesia is the best country in the world.',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Post created successfully',
                'post' => [
                    'title' => 'New Post Title',
                    'content' => 'Indonesia is the best country in the world.',
                ],
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'New Post Title',
            'content' => 'Indonesia is the best country in the world.',
        ]);
    }

    /** @test */
    public function it_can_read_a_post()
    {
        $post = Post::factory()->create([
            'title' => 'Existing Post Title',
            'content' => 'Indonesia is the best country in the world.',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Existing Post Title',
                'content' => 'Indonesia is the best country in the world.',
            ]);
    }

    /** @test */
    public function it_can_update_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/posts/{$post->id}", [
                'title' => 'Updated Title',
                'content' => 'Updated content.',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Post updated successfully',
                'post' => [
                    'title' => 'Updated Title',
                    'content' => 'Updated content.',
                ],
            ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);
    }

    /** @test */
    public function it_can_delete_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Post deleted successfully',
            ]);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
