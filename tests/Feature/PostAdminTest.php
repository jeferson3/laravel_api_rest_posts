<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostAdminTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * test list posts
     * @test
     * @return void
     */
    public function list_posts_user()
    {
        $user = User::whereEmail('email@email.com')->first();
        $token = JWTAuth::fromUser($user);
        $response = $this->json('GET', '/api/admin/posts', array(), array('authorization' => 'Bearer ' . $token));
        $response
            ->assertJsonStructure(['status', 'timestamp', 'data', 'page', 'per_page', 'total'])
            ->assertStatus(200);
    }

    /**
     * test create posts
     * @test
     * @return void
     */
    public function create_posts_user()
    {
        $user = User::whereEmail('email@email.com')->first();
        $token = JWTAuth::fromUser($user);
        $response = $this->json('POST', '/api/admin/posts',
            Post::factory()->raw(),
            array(
                'authorization' => 'Bearer ' . $token
            )
        );
        $response
            ->assertJsonStructure(['data' => ['status', 'timestamp', 'message']])
            ->assertStatus(200);
    }

    /**
     * test update posts
     * @test
     * @return void
     */
    public function update_posts_user()
    {
        $user = User::whereEmail('email@email.com')->first();
        $token = JWTAuth::fromUser($user);
        auth()->login($user);
        $response = $this->json('PUT', '/api/admin/posts/' . Post::create(Post::factory()->raw())->id,
            Post::factory()->raw(['title', 'description']),
            array(
                'authorization' => 'Bearer ' . $token
            )
        );
        $response
            ->assertJsonStructure(['data' => ['status', 'timestamp', 'message']])
            ->assertStatus(200);
    }

    /**
     * test delete posts
     * @test
     * @return void
     */
    public function delete_posts_user()
    {
        $user = User::whereEmail('email@email.com')->first();
        $token = JWTAuth::fromUser($user);
        auth()->login($user);
        $response = $this->json('DELETE', '/api/admin/posts/' . Post::create(Post::factory()->raw())->id,
            array(),
            array(
                'authorization' => 'Bearer ' . $token
            )
        );
        $response
            ->assertJsonStructure(['data' => ['status', 'timestamp', 'message']])
            ->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();
        User::create([
            'name'      => 'user test',
            'email'     => 'email@email.com',
            'password'  => Hash::make('password')
        ]);
    }
}
