<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use LoanModule\Models\LoanApplication;
use LoanModule\Models\LoanStatus;
use Tests\TestCase;
use UserModule\Models\User;

class UserLoanApplicationListTest extends TestCase
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

    public function test_request_empty()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/loan/applications');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["data" => []]);
    }

    public function test_request_not_empty()
    {
        LoanApplication::factory()->create([
            'user_id' => $this->user->id,
            'status_id' => LoanStatus::APPLICATION,
            'bank_user_id' => null,
            'amount' => 10000,
            'term' => 12,
            'start_date' => now(),
            'end_date' => now()->addMonths(12)
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/api/loan/applications');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["data" => [
                [
                    'loan_id' => true,
                    'amount' => true,
                    'term_by_month' => true,
                    'status' => true,
                ]
            ]]);
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
