<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request)
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'ADMIN') {
            return response()->json(['error' => 'Acesso negado'], 403);
        }
        return $next($request);
    }
}
