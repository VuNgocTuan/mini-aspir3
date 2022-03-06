<?php

namespace LoanModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPay extends Model
{
    use HasFactory;

    public $fillable = [
        'loan_id',
        'amount',
        'pay_date',
    ];

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class, 'id', 'loan_id');
    }
}
