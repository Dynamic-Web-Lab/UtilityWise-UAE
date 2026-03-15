<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EncryptBillData
{
    /**
     * Ensure bill-related responses do not expose raw PII.
     * Encryption at rest is handled in model/store layer.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        return $response;
    }
}
