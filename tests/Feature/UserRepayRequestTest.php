<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use LoanModule\Http\Traits\LoanTermTraits;
use LoanModule\Models\LoanApplication;
use LoanModule\Models\LoanStatus;
use Tests\TestCase;
use UserModule\Models\User;

class UserRepayRequestTest extends TestCase
{
    use RefreshDatabase, LoanTermTraits;

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

    public function test_repay_request_ok()
    {
        $loan = LoanApplication::factory()->create([
            'user_id' => $this->user->id,
            'status_id' => LoanStatus::OPEN,
            'bank_user_id' => null,
            'amount' => 10000,
            'term' => 12,
            'start_date' => now(),
            'end_date' => now()->addMonths(12)
        ]);

        $loanId = $loan->id;

        $nextRepayAmount = $this->getNextRepayAmount(
            $loan->start_date,
            $loan->end_date,
            $loan->amount,
            $loan->repays
        );

        $response = $this->actingAs($this->user, 'users')
            ->postJson(
                "/api/loan/applications/$loanId/repay",
                [
                    'amount' => $nextRepayAmount
                ]
            );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["data" => [
                'id' => true,
                'loan_id' => true,
                'amount' => true,
                'repay_date' => true,
            ]]);
    }

    public function test_repay_request_invalid_amount()
    {
        $loan = LoanApplication::factory()->create([
            'user_id' => $this->user->id,
            'status_id' => LoanStatus::OPEN,
            'bank_user_id' => null,
            'amount' => 10000,
            'term' => 12,
            'start_date' => now(),
            'end_date' => now()->addMonths(12)
        ]);

        $loanId = $loan->id;

        $responseFailed = $this->actingAs($this->user, 'users')
            ->postJson(
                "/api/loan/applications/$loanId/repay",
                [
                    'amount' => 1250
                ]
            );

        $responseFailed->assertStatus(Response::HTTP_NOT_ACCEPTABLE)
            ->assertJson(["errors" => true]);
    }

    public function test_repay_request_not_allow()
    {
        $loan = LoanApplication::factory()->create([
            'user_id' => $this->user->id,
            'status_id' => LoanStatus::APPLICATION,
            'bank_user_id' => null,
            'amount' => 10000,
            'term' => 12,
            'start_date' => now(),
            'end_date' => now()->addMonths(12)
        ]);

        $loanId = $loan->id;

        $responseFailed = $this->actingAs($this->user, 'users')
            ->postJson(
                "/api/loan/applications/$loanId/repay",
                [
                    'amount' => 1
                ]
            );

        $responseFailed->assertStatus(Response::HTTP_NOT_ACCEPTABLE)
            ->assertJson(["errors" => true]);
    }

    public function test_repay_request_closed_application_not_allow()
    {
        $loan = LoanApplication::factory()->create([
            'user_id' => $this->user->id,
            'status_id' => LoanStatus::CLOSED,
            'bank_user_id' => null,
            'amount' => 10000,
            'term' => 12,
            'start_date' => now(),
            'end_date' => now()->addMonths(12)
        ]);

        $loanId = $loan->id;

        $responseFailed = $this->actingAs($this->user, 'users')
            ->postJson(
                "/api/loan/applications/$loanId/repay",
                [
                    'amount' => 1250
                ]
            );

        $responseFailed->assertStatus(Response::HTTP_NOT_ACCEPTABLE)
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
