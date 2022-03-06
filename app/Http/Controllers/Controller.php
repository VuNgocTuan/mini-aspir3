<?php

namespace App\Http\Controllers;

use App\Http\Traits\CurrentUserTrait;
use App\Http\Traits\JSONResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        JSONResponseTrait,
        CurrentUserTrait;
}
