<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DecryptImageToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->input('token');

        try {
            $id = Crypt::decrypt($token);

            return $next($request->merge(['id' => $id]));
        } catch (DecryptException $e) {
            Log::error('Error while decrypting image token: ' . $e->getMessage());

            return response()->json(['error' => 'Invalid token'], 401);
        }
    }
}
