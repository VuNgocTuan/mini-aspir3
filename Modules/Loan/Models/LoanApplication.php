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
        'start_date',
        'end_date',
    ];
}
