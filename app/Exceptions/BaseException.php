<?php

namespace App\Exceptions;

use App\Http\Traits\JSONResponseTrait;
use Exception;
use Throwable;

class BaseException extends Exception
{
    use JSONResponseTrait;

    public function render($request)
    {
        return $this->generateErrorResponse($this->getMessage(), $this->getCode());
    }
}
