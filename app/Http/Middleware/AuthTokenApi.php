<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthTokenApi
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
        $apiKey = $request->header('API_KEY');
        $apiToken = $request->header('API_TOKEN');

        if ($apiKey !== env('API_KEY') || $apiToken !== env('API_TOKEN')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Você não tem autorização para acessar este conteúdo.',
            ], 401);
        }

        return $next($request);
    }
}
