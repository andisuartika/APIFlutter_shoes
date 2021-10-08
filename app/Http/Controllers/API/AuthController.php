<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(Request $request){
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(
                [
                    'message' => 'Password Salah!',
                ], 401);
        }
        $token = $user->createToken('token')->plainTextToken;
        return response()->json(
            [
                'success' => true,
                'message' => 'Success',
                'user' => $user,
                'token' => $token,
            ], 200);
    }

    public function logout (Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json(
            [
                'success' => true,
                'message' => 'Logout Success',
            ], 200);
    }
}
