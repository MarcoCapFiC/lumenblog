<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscriptionPlanException extends Exception
{
    public function render(Request $request): Response
    {
        $errorMessage = json_encode('Per accedere a questa funzionalità è necessario fare l\'upgrade del piano');
        return response($errorMessage, 407);
    }
}
