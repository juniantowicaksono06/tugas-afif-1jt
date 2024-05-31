<?php

namespace App\Services;
use Illuminate\Support\Facades\Cookie;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Crypt;

use App\Models\Attendance;

class AttendanceService
{
    public function getAttendance()
    {
        $encryptedToken = Cookie::get('credentials');
        $data = [];
        if($encryptedToken) {
            $decryptedToken = Crypt::decryptString($encryptedToken);
            $currentDateTime = new \DateTime();
            $credentials = JWT::decode($decryptedToken, new Key(env("JWT_SECRET"), env("JWT_ALGO")));
            $currentUser = (array) $credentials;
            $attendance = Attendance::whereBetween('createdAt', [
                $currentDateTime->format('Y-m-d') . ' 00:00:00',
                $currentDateTime->format('Y-m-d') . ' 23:59:59',
            ])
            ->where('userID', $currentUser)
            ->first();
            if(!empty($attendance)) {
                $data = $attendance->toArray();
            }
            return $data;
        }
        return $data;
        
    }
}
