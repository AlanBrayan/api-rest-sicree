<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Ionos;

class ApiAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'No token provided'], 401);
        }

        
        $token = str_replace('Bearer ', '', $token);

        
        $ionos = Ionos::where('api_token', $token)->first();

        if (!$ionos) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        
        $request->attributes->add(['ionos' => $ionos]);

        return $next($request);
    }
}