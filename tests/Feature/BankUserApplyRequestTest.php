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
use UserModule\Models\User;

class BankUserApplyRequestTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_loan_apply_request_ok()
    {
        $bankUser = $this->createBankUser();
        $user = $this->createUser();
        $loanApplication = LoanApplication::factory()->create([
            'user_id' => $user->id,
            'status_id' => LoanStatus::APPLICATION,
            'bank_user_id' => null,
            'amount' => 10000,
            'term' => 12,
            'start_date' => now(),
            'end_date' => now()->addMonths(12)
        ]);
        $this->assertModelExists($bankUser);
        $this->assertModelExists($user);
        $this->assertModelExists($loanApplication);

        $response = $this->actingAs($bankUser)->postJson(
            'api/loan/banker/applications/apply',
            [
                'id' => $loanApplication->id
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
    }
    public function test_loan_apply_request_invalidate()
    {
        $bankUser = $this->createBankUser();
        $user = $this->createUser();
        $loanApplication = LoanApplication::factory()->create([
            'user_id' => $user->id,
            'status_id' => LoanStatus::APPLICATION,
            'bank_user_id' => null,
            'amount' => 10000,
            'term' => 12,
            'start_date' => now(),
            'end_date' => now()->addMonths(12)
        ]);
        $this->assertModelExists($bankUser);
        $this->assertModelExists($user);
        $this->assertModelExists($loanApplication);

        $response = $this->actingAs($bankUser)->postJson(
            'api/loan/banker/applications/apply',
            [
                'id' => 'invalid'
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(["errors" => ["id" => true]]);
    }
    public function test_loan_apply_request_already_apply()
    {
        $bankUser = $this->createBankUser();
        $user = $this->createUser();
        $loanApplication = LoanApplication::factory()->create([
            'user_id' => $user->id,
            'status_id' => LoanStatus::CLOSED,
            'bank_user_id' => null,
            'amount' => 10000,
            'term' => 12,
            'start_date' => now(),
            'end_date' => now()->addMonths(12)
        ]);
        $this->assertModelExists($bankUser);
        $this->assertModelExists($user);
        $this->assertModelExists($loanApplication);

        $response = $this->actingAs($bankUser)->postJson(
            'api/loan/banker/applications/apply',
            [
                'id' => $loanApplication->id
            ]
        );

        $response->assertStatus(Response::HTTP_NOT_ACCEPTABLE)
            ->assertJson(["errors" => true]);
    }

    private function createBankUser(): BankUser
    {
        $email = 'bank-user@banker.com';
        $password = '1234@1234';

        return BankUser::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }

    private function createUser(): User
    {
        $email = 'loan-user@dev.com';
        $password = '1234@1234';

        return User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
