<?php

namespace LoanModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'status_id',
        'bank_user_id',
        'amount',
        'term',
        'start_date',
        'end_date',
    ];

    public function status()
    {
        return $this->hasOne(LoanStatus::class, 'id', 'status_id');
    }

    public function repays()
    {
        return $this->hasMany(LoanPay::class, 'loan_id', 'id');
    }
}
