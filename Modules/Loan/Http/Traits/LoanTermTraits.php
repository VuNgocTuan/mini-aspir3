<?php

namespace LoanModule\Http\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

trait LoanTermTraits
{
    public function calculateWeeksNeedToPay($startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        return $startDate->weeksUntil($endDate)->count();
    }

    public function getLoanAmountRemains(Collection $repays, $amount): string
    {
        $totalRepays = $repays->pluck('amount')->sum();
        $loanAmountRemain = $amount - $totalRepays;

        return max($loanAmountRemain, 0);
    }

    public function getWeeklyLoanAmountRepay($startDate, $endDate, $amount): string
    {
        $totalWeeks = $this->calculateWeeksNeedToPay($startDate, $endDate);

        $amount = $amount / $totalWeeks;

        return number_format($amount, 2, '.', '');
    }

    private function getNextRepayAmount($statDate, $endDate, $totalLoanAmount, $repays)
    {
        $nextRepayAmount = $this->getWeeklyLoanAmountRepay(
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
            $nextRepayAmount = $this->getLoanAmountRemains($repays, $totalLoanAmount);
        }

        return $nextRepayAmount;
    }
}
