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

class HandleWebAuth {
    public function handle(Request $request, Closure $next) {
        try {
            $encryptedToken = null;
            
            if(!empty(Cookie::get('credentials'))) {
                if($request->path() == 'login' || $request->path() == 'register')  {
                    return redirect('/');
                }
                $encryptedToken = Cookie::get('credentials');
            }
            else {
                if($request->path() != 'login' && $request->path() != 'register')  {
                    Cookie::queue(Cookie::forget('credentials'));
                    Cookie::queue(Cookie::forget('refresh_credentials'));
                    return redirect('/login');
                }
                else {
                    return $next($request);
                }
            }
            // Decrypt to validate the token.
            // If it's cannot be decrypted then it's not valid
            $decryptedToken = Crypt::decryptString($encryptedToken);
            $credentials = JWT::decode($decryptedToken, new Key(env("JWT_SECRET"), env("JWT_ALGO")));
            $credentials = (array) $credentials;
            $request->merge([
                'credentials'   => $credentials
            ]);
            return $next($request);
        }
        catch(\Exception $err) {
            // Delete cookie if cookie is detected
            Cookie::queue(Cookie::forget('credentials'));
            Cookie::queue(Cookie::forget('refresh_credentials'));
            return redirect('/login');
        }
    } 
}