<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use UserModule\Models\User;

class UserLoanRequestTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
    }

    public function test_user_exists()
    {
        $this->assertModelExists($this->user);
    }

    public function test_loan_request_application()
    {
        $response = $this->actingAs($this->user, 'users')
            ->postJson(
                '/api/loan/applications',
                [
                    'term_by_month' => 12,
                    'amount' => 1250
                ]
            );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["data" => [
                'loan_id' => true,
                'amount' => true,
                'term_by_month' => true,
                'status' => true,
                'created_at' => true,
            ]]);
    }

    public function test_loan_request_invalidate()
    {
        $response = $this->actingAs($this->user, 'users')
            ->postJson(
                '/api/loan/applications',
                [
                    'term_by_month' => 'double',
                    'amount' => '-1'
                ]
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_loan_request_not_accept()
    {
        $response = $this->actingAs($this->user, 'users')
            ->postJson(
                '/api/loan/applications',
                [
                    'term_by_month' => 12,
                    'amount' => 1250
                ]
            );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["data" => [
                'loan_id' => true,
                'amount' => true,
                'term_by_month' => true,
                'status' => true,
                'created_at' => true,
            ]]);

        $responseUnaccepted = $this->actingAs($this->user, 'users')
            ->postJson(
                '/api/loan/applications',
                [
                    'term_by_month' => 12,
                    'amount' => 1250
                ]
            );

        $responseUnaccepted->assertStatus(Response::HTTP_NOT_ACCEPTABLE)
            ->assertJson(["errors" => true]);
    }

    private function createUser(): User
    {
        $email = 'test-loan@dev.com';
        $password = '1234@1234';

        return User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
