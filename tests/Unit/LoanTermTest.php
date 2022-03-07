<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use LoanModule\Http\Traits\LoanTermTraits;
use PHPUnit\Framework\TestCase;

class LoanTermTest extends TestCase
{
    use LoanTermTraits;

    public function test_week_range()
    {
        //39 weeks and 2 days => 40 weeks total
        $startDate = '2022/03/08';
        $endDate = '2022/12/08';

        $weekRange = $this->calculateWeeksNeedToPay($startDate, $endDate);

        $this->assertIsNumeric($weekRange);
        $this->assertEquals($weekRange, 40);
    }

    public function test_loan_amount_remain()
    {
        $repays = Collection::make();
        //Repays = 10 * 10, currentLoan = 200 => remain = 100
        $currentLoanAmount = 200;

        for ($i = 0; $i < 10; $i++) {
            $repays->add(['amount' => 10]);
        }

        $loanAmountRemain = $this->getLoanAmountRemains($repays, $currentLoanAmount);

        $this->assertIsNumeric($loanAmountRemain);
        $this->assertEquals($loanAmountRemain, 100);
    }

    public function test_weekly_loan_amount_repay()
    {
        //39 weeks and 2 days => 40 weeks total
        $startDate = '2022/03/08';
        $endDate = '2022/12/08';
        $totalLoanAmount = 100000;

        //weeklyLoanAmountRepay / 40
        $weeklyLoanAmountRepay = $this->getWeeklyLoanAmountRepay(
            $startDate,
            $endDate,
            $totalLoanAmount
        );

        $this->assertIsNumeric($weeklyLoanAmountRepay);
        $this->assertEquals($weeklyLoanAmountRepay, 2500);
    }

    public function test_next_repay_amount()
    {
        //39 weeks and 2 days => 40 weeks total
        $startDate = '2022/03/08';
        $endDate = '2022/12/08';
        $totalLoanAmount = 100000;
        $repays = Collection::make();

        for ($i = 0; $i < 10; $i++) {
            $repays->add(['amount' => 2500]);
        }

        $nextRepayAmount = $this->getNextRepayAmount(
            $startDate,
            $endDate,
            $totalLoanAmount,
            $repays
        );

        $this->assertIsNumeric($nextRepayAmount);
        $this->assertEquals($nextRepayAmount, 2500);
    }
}
