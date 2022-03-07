<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use UserModule\Models\User;
use UserModule\Services\AuthService;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase;
    private AuthService $authService;

    public function setUp(): void
    {
        parent::setUp();
        $this->authService = app(AuthService::class);
    }

    public function test_authenticate_success()
    {
        $email = 'test@dev.com';
        $password = '1234@1234';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $token = $this->authService->authenticate($email, $password);
        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);

        $this->assertIsString($token);
    }

    public function test_authenticate_fail()
    {
        $token = $this->authService->authenticate('null', 'null');

        $this->assertNull($token);
    }

    public function test_authenticate_request_ok()
    {
        $email = 'test@dev.com';
        $password = '1234@1234';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $response = $this->postJson(
            '/api/user/auth',
            [
                'email' => $email,
                'password' => $password
            ]
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['token' => true]);
    }

    public function test_authenticate_request_invalidate()
    {
        $email = 'test12345';
        $password = '';

        $response = $this->postJson(
            '/api/user/auth',
            [
                'email' => $email,
                'password' => $password
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                "errors" => []
            ]);
    }

    public function test_authenticate_request_invalid_credentials()
    {
        $email = 'test@dev.com';
        $password = '1234@1234';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $response = $this->postJson(
            '/api/user/auth',
            [
                'email' => $email,
                'password' => '1111111'
            ]
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
