<?php

namespace App\Http\Traits;

use Illuminate\Http\Response;

trait JSONResponseTrait
{
    public function generateSuccessResponse(array $data = [])
    {
        return response()->json($data, Response::HTTP_OK);
    }

    public function generateErrorResponse(string $msg, int $code = Response::HTTP_NOT_FOUND)
    {
        return response()->json([
            'error' => $msg
        ], $code);
    }
}
