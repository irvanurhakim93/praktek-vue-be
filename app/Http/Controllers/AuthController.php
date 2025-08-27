<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        // Validasi input
        $this->validate(
            $request,
            [
                'username' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'username.required' => 'Username wajib diisi.',
                'password.required' => 'Kata sandi wajib diisi.',
            ]
        );

        $credentials = $request->only('username', 'password');
        $credentials['username'] = strtolower($credentials['username']); // Convert username to lowercase

        $user = User::where('username', $credentials['username'])->first();



        // Cek password (tanpa LDAP)
        if (!Hash::check($credentials['password'], $user->password)) {
            LogHelper::create("Login, Password salah - " . $credentials['username'], $user->id);
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ], 401);
        }

        // Buat token
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);

        }

        public function logout()
        {
            $userAuth = Auth::user();

            Auth::logout();
            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil logout'
            ]);
        }


}