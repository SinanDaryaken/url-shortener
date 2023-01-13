<?php

namespace App\Exceptions;

use App\Facades\JsonOutputFaced;
use Exception;
use Illuminate\Http\JsonResponse;

class SlugExceptions extends Exception
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return JsonOutputFaced::setStatusCode(404)->setMessage('Not Found')->response();
    }
}
