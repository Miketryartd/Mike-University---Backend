<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAPIKeyIsPresent
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader('X-API-KEY')){
            return response()->json(["message" => "API KEY HEADER is missing"], 401);
        }
        if ($request->header('X-API-KEY') !== env('API_KEY')){
            return response()->json(["message" => "Invalid API KEY"], 422);
        }
        return $next($request);
    }
}
