<?php

namespace Tests\Feature;

use BankUserModule\Models\BankUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use LoanModule\Models\LoanApplication;
use LoanModule\Models\LoanStatus;
use Tests\TestCase;

class BankUserLoanApplicationListTest extends TestCase
{
    use RefreshDatabase;

    protected BankUser $user;

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
            ->getJson('/api/loan/banker/applications');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["data" => []]);
    }

    public function test_request_not_empty()
    {
        LoanApplication::factory()->create([
            'user_id' => 1,
            'status_id' => LoanStatus::APPLICATION,
            'bank_user_id' => null,
            'amount' => 10000,
            'term' => 12,
            'start_date' => now(),
            'end_date' => now()->addMonths(12)
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/api/loan/banker/applications');

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

    private function createUser(): BankUser
    {
        $email = 'bank-user@banker.com';
        $password = '1234@1234';

        return BankUser::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
