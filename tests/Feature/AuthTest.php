<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @return void
     */
    public function login_user()
    {
        $response = $this->json('POST', '/api/auth/login', array(
            'email'     => 'email@email.com',
            'password'  => 'password'
        ));
        $response->assertJsonStructure(['status', 'timestamp', 'token'])
            ->assertStatus(200);
    }

    /**
     * @test
     * @return void
     */
    public function logout_user()
    {
        $user = User::whereEmail('email@email.com')->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->json('POST', '/api/auth/logout', array(), array('authorization' => 'Bearer ' . $token));
        $response->assertJsonStructure(['data' => ['status', 'timestamp', 'message']])
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
