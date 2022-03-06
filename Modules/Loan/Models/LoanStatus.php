<?php

namespace LoanModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanStatus extends Model
{
    use HasFactory;

    public const APPLICATION = 1;
    public const OPEN = 2;
    public const CLOSED = 3;

    public $timestamps = false;

    public $fillable = ['name'];
}
