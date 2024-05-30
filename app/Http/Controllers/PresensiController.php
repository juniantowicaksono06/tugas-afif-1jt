<?php

namespace App\Http\Controllers;

use App\Models\MasterUser;
use App\Models\Users;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use App\Rules\UserTypeRule;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Illuminate\Contracts\Encryption\DecryptException;

class PresensiController extends Controller {
    private $valid_refresh_token;
    public function presensi() {
        return view('presensi.presensi', [
            'title' => 'Halaman Presensi'
        ]);
    } 
    
    public function riwayat() {
        return view('presensi.riwayat', [
            'title' => 'Halaman Riwayat Presensi'
        ]);
    } 
}