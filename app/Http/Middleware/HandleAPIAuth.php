<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class HandleAPIAuth {
    public function handle(Request $request, Closure $next) {
        try {
            $encryptedToken = null;
            $useCookie = false;
            if(!empty(Cookie::get('credentials'))) {
                $encryptedToken = Cookie::get('credentials');
            }
            else {
                return response()->json([
                    'status'    => 403,
                    'message'   => "Sesi tidak valid"
                ], 403);
            }
            // Decrypt to validate the token.
            // If it's cannot be decrypted then it's not valid
            $decryptedToken = Crypt::decryptString($encryptedToken);
            $credentials = JWT::decode($decryptedToken, new Key(env("JWT_SECRET"), env("JWT_ALGO")));
            $request->user_type = $credentials->user_type;
            return $next($request);
        }
        catch(\Exception $err) {
            // Delete cookie if cookie is detected
            Cookie::queue(Cookie::forget('credentials'));
            Cookie::queue(Cookie::forget('refresh_credentials'));
            return response()->json([
                'status'    => 403,
                'message'   => "Sesi tidak valid"
            ], 403);
        }
    } 
}