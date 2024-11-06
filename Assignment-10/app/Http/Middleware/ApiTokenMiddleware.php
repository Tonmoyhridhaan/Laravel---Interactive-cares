<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        
        $apiToken = $request->header('Authorization');


        if (!$apiToken || !User::where('api_token', $apiToken)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = User::where('api_token', $apiToken)->first();
        $request->user = $user; // Assign the user to the request object

        return $next($request);
    }
    
}
