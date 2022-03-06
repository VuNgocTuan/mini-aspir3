<?php

namespace LoanModule\Services;

use Illuminate\Support\Facades\DB;
use LoanModule\Exceptions\LoanRepayAmountNotValidException;
use LoanModule\Http\Traits\LoanTermTraits;
use LoanModule\Models\LoanApplication;
use LoanModule\Models\LoanStatus;
use UserModule\Models\User;

class LoanUserService extends LoanService
{
    use LoanTermTraits;

    public function isUserCanApply(User $user): bool
    {
        return $this->loanApplicationRepository->isUserCanApply($user->id);
    }

    public function apply(User $user, int $termByMonth, $amount): LoanApplication
    {
        return $this->loanApplicationRepository->apply($user->id, $termByMonth, $amount);
    }

    public function getLoanApplicationList(User $user)
    {
        return $this->loanApplicationRepository->getListOfUser($user->id);
    }

    public function repay(User $user, int $loanApplicationId, $amount)
    {
        return DB::transaction(function () use ($user, $loanApplicationId, $amount) {
            $loanApplication = $this->loanApplicationRepository->getLoanApplicationToRepay(
                $user->id,
                $loanApplicationId
            );
            
            $totalLoanAmount = $loanApplication->amount;

            $weeklyLoanAmount = $this->getWeeklyLoanAmount(
                $loanApplication->start_date,
                $loanApplication->end_date,
                $totalLoanAmount,
                $loanApplication->repays
            );

            //Check if amount not equal to weekly loan amount repay
            $this->checkAmountNotEqualToWeeklyLoanAmount(
                $weeklyLoanAmount,
                $amount
            );

            $newRepay = $this->loanPayRepository->repay($loanApplicationId, $amount);

            //Check if the last repay, close the loan application
            $allRepayAmount = $this->loanPayRepository
                ->getList($loanApplicationId)
                ->pluck('amount')
                ->sum();
            if ($this->isLastRepayToClosed($totalLoanAmount, $allRepayAmount)) {
                $this->loanApplicationRepository->updateStatus($loanApplicationId, LoanStatus::CLOSED);
            }

            return $newRepay;
        });
    }

    private function checkAmountNotEqualToWeeklyLoanAmount($weeklyLoanAmount, $repayAmount)
    {
        if ($repayAmount != $weeklyLoanAmount) {
            throw new LoanRepayAmountNotValidException($weeklyLoanAmount);
        }
    }

    private function isLastRepayToClosed($totalLoanAmount, $allRepayAmount): bool
    {
        return $totalLoanAmount - $allRepayAmount <= 0;
    }

    private function getWeeklyLoanAmount($statDate, $endDate, $totalLoanAmount, $repays)
    {
        $weeklyLoanAmount = $this->getWeeklyLoanAmountRepay(
            $statDate,
            $endDate,
            $totalLoanAmount,
        );

        $totalWeeksNeedToPay = $this->calculateWeeksNeedToPay(
            $statDate,
            $endDate
        );
        $totalWeeksRepay = $repays->count();

        if ($totalWeeksNeedToPay - $totalWeeksRepay == 1) {
            $weeklyLoanAmount = $this->getLoanAmountRemains($repays, $totalLoanAmount);
        }

        return $weeklyLoanAmount;
    }
}
