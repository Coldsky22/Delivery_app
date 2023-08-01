<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSecretToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('secret-token');

        if (!$token || $token !== 'your-secret-token') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
