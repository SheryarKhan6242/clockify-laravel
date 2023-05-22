<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FormDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // return response()->json($request->header('Content-Type'));
        if ($request->header('Content-Type') == 'application/json' || $request->header('Content-Type') == '' ) {
            return response()->json(['error' => 'Request must be sent as form-data.'], 400);
        }
        return $next($request);
    }
}
