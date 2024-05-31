<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Attendance;

class AttendanceController extends Controller {
    private $valid_refresh_token;
    public function presensi(Request $request) {
        return view('presensi.presensi', [
            'title' => 'Halaman Presensi'
        ]);
    } 
    
    public function riwayat() {
        return view('presensi.riwayat', [
            'title' => 'Halaman Riwayat Presensi'
        ]);
    } 

    public function actionPresensi(Request $request) {
        $fullPath = null;
        try {
            $validator = Validator::make($request->all(), [
                'longitude'     => 'required',
                'latitude'      => 'required',
                'condition'     => 'required',
                'activity'      => 'required',
                'picture'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]); 
            if($validator->fails()) {
                return response()->
                json([
                    'status'    => 400,
                    'message'   => $validator->errors()
                ], 400);
            }
            $currentUser = $request['credentials'];
            $currentDateTime = new \DateTime();
            $input = $validator->validated();
            $attendance = Attendance::whereBetween('createdAt', [
                $currentDateTime->format('Y-m-d') . ' 00:00:00',
                $currentDateTime->format('Y-m-d') . ' 23:59:59',
            ])
            ->where('userID', $currentUser)
            ->first();
            $imageName = time().'_'.$currentUser['userID'].'.'.$request->picture->extension();
            if(empty($attendance)) {
                $request->picture->move(public_path('images/attendance/clocked-in'), $imageName);
                $fullPath = "images/attendance/clocked-in/" . $imageName;
                $message = "Berhasil Clocked In";
                // Belum clocked in atau presensi masuk jadi presensi sekarang akan jadi presensi pulang
                Attendance::create([
                    'userID'            => $currentUser['userID'],
                    'clockedIn'         => $currentDateTime->format('Y-m-d H:i:s'),
                    'clockedOut'        => null,
                    'activity'          => $input['activity'],
                    'longitudeIn'       => $input['longitude'],
                    'latitudeIn'        => $input['latitude'],
                    'condition'         => $input['condition'],
                    'longitudeOut'      => null,
                    'latitudeOut'       => null,
                    'pictureIn'         => $fullPath,
                    'pictureOut'        => null
                ]);
            }
            else {
                if(!empty($attendance->clockedOut) && !empty($attendance->clockedIn)) {
                    return response()
                    ->json([
                        'status'=> 200,
                        'message'=> "Anda telah melakukan presensi hari ini"
                    ]);
                }
                $request->picture->move(public_path('images/attendance/clocked-out'), $imageName);
                $fullPath = "images/attendance/clocked-out/" . $imageName;
                // Sudah clocked in atau presensi masuk jadi presensi sekarang akan jadi presensi pulang
                $message = "Berhasil Clocked Out";
                Attendance::whereBetween('createdAt', [
                    $currentDateTime->format('Y-m-d') . ' 00:00:00',
                    $currentDateTime->format('Y-m-d') . ' 23:59:59',
                ])
                ->where('userID', $currentUser['userID'])
                ->update([
                    'clockedOut'        => $currentDateTime->format('Y-m-d H:i:s'),
                    'activity'          => $input['activity'],
                    'condition'         => $input['condition'],
                    'longitudeOut'      => $input['longitude'],
                    'latitudeOut'       => $input['latitude'],
                    'pictureOut'        => $fullPath
                ]);
            }
            return response()->json([
                'status'=> 200,
                'message'=> $message
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
}