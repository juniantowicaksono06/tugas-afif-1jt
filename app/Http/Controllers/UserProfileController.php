<?php 

namespace App\Http\Controllers;
use App\Models\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Firebase\JWT\Key;

class UserProfileController extends Controller {
    private $valid_refresh_token;
    public function editProfil() {
        return view('editprofil', [
            'title' => "Edit Profil"
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

    public function actionEdit(Request $request, $id) {
        $fullPath = null;
        try {
            $validator = Validator::make($request->all(), [
                'email'     => 'required|email',
                'fullname'  => 'required|max:200',
                'position'  => 'required|max:200',
                'password'  => 'sometimes|confirmed',
                'picture'   => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]); 
            if($validator->fails()) {
                return response()->
                json([
                    'status'    => 400,
                    'message'   => $validator->errors()
                ], 400);
            }
            $myUser = MasterUser::where('userID', $id)->first()->toArray();
            if(empty($myUser)) {
                return response()->json([
                    'status'    => 404,
                    'message'   => "User tidak ditemukan"
                ], 200);
            }
            $input = $validator->validated();
            $data = [
                'email'     => $input['email'],
                'fullname'  => $input['fullname'],
                'position'  => $input['position'],
                'picture'   => $myUser['picture']
            ];

            if(array_key_exists('password', $input)) {
                if(!empty($input['password'])) {
                    $data['password'] = Hash::make($input['password']);
                }
            }
            
            if(array_key_exists('picture', $input)) {
                $imageName = time().'.'.$request->picture->extension();
                $request->picture->move(public_path('images'), $imageName);
                $fullPath = "images/" . $imageName;
                $data['picture'] = $fullPath;
            }
            MasterUser::where('userID', $id)
            ->update($data);
            $data['userID'] = $id;
            if($fullPath !== null) {
                unlink(public_path($myUser['picture']));
            }
            $token = $this->makeJwt($data);
            return response()->json([
                'status'    => 200,
                'message'    => 'Berhasil ubah profil user',
                'token'     => [
                    'access'    => $token['access_token'],
                    'refresh'   => $token['refresh_token']
                ]
            ], 200)
            ->withCookie($token['access_token_cookie'])
            ->withCookie($token['refresh_token_cookie']);
        } catch (\Throwable $e) {

            return response()->json([
                'status'=> 500,
                'message'=> $e->getMessage()
            ], 500);
        }
    }
}