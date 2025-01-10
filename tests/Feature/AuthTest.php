<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private $faker;
    private $testEmail;
    private $testPassword;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create('tr_TR');
        $this->testEmail = $this->faker->unique()->safeEmail();
        $this->testPassword = $this->faker->password(8, 20);
    }

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => $this->faker->name(),
            'email' => $this->testEmail,
            'password' => $this->testPassword,
            'password_confirmation' => $this->testPassword
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'user' => ['id', 'name', 'email'],
                    'token'
                ]);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => $this->testEmail,
            'password' => bcrypt($this->testPassword)
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $this->testEmail,
            'password' => $this->testPassword
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'user' => ['id', 'name', 'email'],
                    'token'
                ]);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200);
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_user_can_get_profile()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/auth/user');

        $response->assertStatus(200)
                ->assertJson([
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]);
    }
} 