<?php

namespace App\Http\Controllers;

use App\Models\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Illuminate\Contracts\Encryption\DecryptException;

class AuthController extends Controller {
    private $valid_refresh_token;
    public function login() {
        return view('login', [
            'title' => 'Halaman Login'
        ]);
    }  
    
    public function register() {
        return view('register', [
            'title' => 'Halaman Registrasi'
        ]);
    } 

    public function makeJwt($user) {
        // Payload untuk JWT
        $access_payload = [
            'userID'   => $user['userID'],
            'email'    => $user['email'],
            'fullname' => $user['fullname'],
            'position' => $user['position'],
            'picture'  => $user['picture'],
            'iat'      => time(),
            'exp'      => time() + 60 * 60 * 24
        ];
        $refresh_payload = [
            'userID'   => $user['userID'],
            'email'    => $user['email'],
            'fullname' => $user['fullname'],
            'position' => $user['position'],
            'picture'  => $user['picture'],
            'iat'      => time(),
            'exp'      => $this->valid_refresh_token
        ];
        // Membuat JWT Token
        $access_token = JWT::encode($access_payload, env('JWT_SECRET'), 'HS256');
        $refresh_token = JWT::encode($refresh_payload, env('JWT_REFRESH_SECRET'), 'HS256');

        // Enkripsi token
        $encrypted_access_token = Crypt::encryptString($access_token);
        $encrypted_refresh_token = Crypt::encryptString($refresh_token);

        // Memmbuat cookie
        $access_token_cookie = Cookie::make('credentials', $encrypted_access_token, 60 * 24, '/', null, false, true);
        $refresh_token_cookie = Cookie::make('refresh_credentials', $encrypted_refresh_token, 60 * 24, '/', null, false, true);
        return [
            'access_token'          => $encrypted_access_token,
            'refresh_token'         => $encrypted_refresh_token,
            'access_token_cookie'   => $access_token_cookie,
            'refresh_token_cookie'  => $refresh_token_cookie,
        ];
    }
    
    // API untuk Login
    public function actionLogin(Request $request) {
        try {
            $this->valid_refresh_token = time() + 60 * 60 * 24;

            $validator = Validator::make($request->all(), [
                'email'     => 'required|email',
                'password'  => 'required'
            ]); 
            if($validator->fails()) {
                return response()->
                json([
                    'status'    => 400,
                    'message'   => $validator->errors()
                ], 400);
            }
    
            $input = $validator->validated();
    
            // Cek apakah user ada di database?
            $user = MasterUser::where('email', $input['email'])->first();
            if(empty($user)) {
                return response()->
                json([
                    'status'  => 404,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }
    
            if(!Hash::check($input['password'], $user['password'])) {
                return response()->json([
                    'status'    => 401,
                    'message'   => "Email atau password salah"
                ], 200);
            }

            $token = $this->makeJwt($user);
    
            return response()->json([
                'status'    => 200,
                'message'   => 'Login sukses',
                'token'     => [
                    'access'    => $token['access_token'],
                    'refresh'   => $token['refresh_token']
                ]
            ], 200)
            ->withCookie($token['access_token_cookie'])
            ->withCookie($token['refresh_token_cookie']);
        }
        catch (\Throwable $e) {
            return response()->json([
                'status'    => 500,
                'message'   => 'Server error'
            ]);
        }
    }

    // API untuk register
    public function actionRegister(Request $request) {
        $fullPath = null;
        try {
            // Check apakah user yang input ini adalah super admin atau bukan?
            $validator = Validator::make($request->all(), [
                'email'     => 'required|email',
                'fullname'  => 'required|max:200',
                'position'  => 'required|max:200',
                'password'  => 'required|min:8|confirmed',
                'picture'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]); 
            if($validator->fails()) {
                return response()->
                json([
                    'status'    => 400,
                    'message'   => $validator->errors()
                ], 400);
            }
            $imageName = time().'.'.$request->picture->extension();
            $request->picture->move(public_path('images'), $imageName);
            $fullPath = "images/" . $imageName;

            $input = $validator->validated();
            $user = MasterUser::where('email', $input['email'])->first();

            if(!empty($user)) {
                return response()->json([
                    'status'    => 409,
                    'message'   => 'Email telah digunakan'
                ], 409);
            }

            MasterUser::create([
                'email'         => $input['email'],
                'fullname'      => $input['fullname'],
                'position'      => $input['position'],
                'password'      => Hash::make($input['password']),
                'picture'       => $fullPath
            ]);
            return response()->json([
                'status'=> 200,
                'message'=> 'User berhasil dibuat'
            ], 200);
            
        } catch (\Throwable $e) {
            if($fullPath !== null) {
                if(file_exists(public_path($fullPath))) {
                    unlink(public_path($fullPath));
                }
            }
            return response()->json([
                'status'=> 500,
                'message'=> $e->getMessage()
            ], 500);
        }
    }

    // API untuk refresh token
    public function actionRefreshToken(Request $request) {
        $refresh_credentials = $request->cookie('refresh_credentials');
        if (empty($refresh_credentials)) {
            return response()->json([
                'status' => 400,
                'message' => 'Refresh token not exist'
            ], 400);
        }
        try {
            $refresh_credentials = Crypt::decryptString($refresh_credentials);
            $credentials = JWT::decode($refresh_credentials, new Key(env('JWT_REFRESH_SECRET'), 'HS256'));
            $user = MasterUser::where('email', $credentials->email)->first();
            if ($user) {
                // $token = $this->jwtWeb($user);
                $token = $this->makeJwt($user);

                return response()
                    ->json([
                        'status'    => 200,
                        'message'   => "Token berhasil di refresh",
                        'token'      => [
                            'access'    => $token['access_token'],
                            'refresh'   => $token['refresh_token']
                        ]
                    ], 200)
                    ->withCookie($token['access_token_cookie'])
                    ->withCookie($token['refresh_token_cookie']);
            }
            Cookie::queue(Cookie::forget('credentials'));
            Cookie::queue(Cookie::forget('refresh_credentials'));
            return response()->json([
                'status'       => 404,
                'message'      => 'User tidak ditemukan'
            ], 404);
        } catch (DecryptException $e) {
            Cookie::queue(Cookie::forget('credentials'));
            Cookie::queue(Cookie::forget('refresh_credentials'));
            return response()->json([
                'status'    => 401,
                'error'     => 'Token tidak valid'
            ], 401);
        } catch (ExpiredException $e) {
            Cookie::queue(Cookie::forget('credentials'));
            Cookie::queue(Cookie::forget('refresh_credentials'));
            return response()->json([
                'status'    => 401,
                'error'     => 'Token telah expired'
            ], 401);
        } catch (\Exception $err) {
            Cookie::queue(Cookie::forget('credentials'));
            Cookie::queue(Cookie::forget('refresh_credentials'));
            return response()->json([
                'status'    => 500,
                'message'   => 'Server error'
            ], 500);
        }
    }

    public function actionWebLogout(Request $request) {
        Cookie::queue(Cookie::forget('credentials'));
        Cookie::queue(Cookie::forget('refresh_credentials'));
        return redirect('/login');
    }

    public function actionLogout(Request $request) {
        Cookie::queue(Cookie::forget('credentials'));
        Cookie::queue(Cookie::forget('refresh_credentials'));
        return response()->json([
            'status'    => 200,
            'message'   => "Berhasil logout"
        ], 200);
    }
}