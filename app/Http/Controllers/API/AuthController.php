<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = Login::where('email', $request->email)->first();

        if(!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $token = $user->createToken('token-name')->plainTextToken;

        $response[] = [
            'id' => $user->id,
            'email' => $user->email,
            'nama_lengkap' => $user->User->nama_lengkap,
            'no_hp' => $user->User->no_hp,
            'no_rekening' => $user->User->rekening,
            'lokasi' => $user->User->Lokasi->nama_lokasi,
            'token' => $token
        ];

        if($response)
            return ResponseFormatter::success($response, 'Data Sewa Kios Berhasil di Ambil');
        else
            return ResponseFormatter::error(null, 'Data Sewa Kios Tidak Ada', 404);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
