<?php

namespace App\Services;
use Illuminate\Support\Facades\Cookie;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Crypt;

use App\Models\MasterMenu;

class UserProfileService
{
    public function getProfile()
    {
        $encryptedToken = Cookie::get('credentials');
        if($encryptedToken) {
            $decryptedToken = Crypt::decryptString($encryptedToken);
            $credentials = JWT::decode($decryptedToken, new Key(env("JWT_SECRET"), env("JWT_ALGO")));
            return [
                'email'     => $credentials->email,
                'fullname'  => $credentials->fullname,
                'position'  => $credentials->position,
                'picture'   => $credentials->picture,
                'userID'    => $credentials->userID
            ];
        }
        return [
            'email'     => "",
            'fullname'  => "",
            'position'  => "",
            'picture'   => "",
            'userID'    => ""
        ];
    }
}
