<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostCustomerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * test list posts
     * @test
     * @return void
     */
    public function list_posts()
    {
        $user = User::whereEmail('email@email.com')->first();
        $token = JWTAuth::fromUser($user);
        $response = $this->json('GET', '/api/posts', array(), array('authorization' => 'Bearer ' . $token));
        $response
            ->assertJsonStructure(['status', 'timestamp', 'data', 'page', 'per_page', 'total'])
            ->assertStatus(200);
    }

    /**
     * test comment on post
     * @test
     * @return void
     */
    public function comment_posts()
    {
        $user = User::whereEmail('email@email.com')->first();
        $token = JWTAuth::fromUser($user);
        auth()->login($user);
        $response = $this->json('POST', '/api/posts/' . Post::create(Post::factory()->raw())->id . '/comments',
            array(
                'comment'  => Str::random(150)
            ),
            array('authorization' => 'Bearer ' . $token)
        );
        $response
            ->assertJsonStructure(['data' => ['status', 'timestamp', 'message']])
            ->assertStatus(200);
    }

    /**
     * test like on post
     * @test
     * @return void
     */
    public function like_posts()
    {
        $user = User::whereEmail('email@email.com')->first();
        $token = JWTAuth::fromUser($user);
        auth()->login($user);
        $response = $this->json('POST', '/api/posts/' . Post::create(Post::factory()->raw())->id . '/likes',
            array(),
            array('authorization' => 'Bearer ' . $token)
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
