<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController
{
    public static function login(Request $request)
    {
        $body = $request->all();
        $password = $body['password'];
        $credentials = $request->only('username', 'password');


        $userFindedByUsername = User::where('username', $request->input('username'))->first();

        if (!$userFindedByUsername) {
            return response()->json(['error' => 'User is not existed'], 401);
        }

        $catched = !(strcmp($request->input('password'), $userFindedByUsername->password) !== 0);
        // $catched = Hash::check($request->input('password'), $userFindedByUsername->password);
        if (!$userFindedByUsername || !$catched) {
            return response()->json(['error' => 'Unthorization'], 401);
        }
        $accessToken = JWTAuth::claims(['exp' => Carbon::now()->addDays(1)->timestamp])->fromUser($userFindedByUsername);
        $refreshToken = JWTAuth::claims(['exp' => Carbon::now()->addWeeks(1)->timestamp])->fromUser($userFindedByUsername);

        return response()->json(compact('accessToken', 'refreshToken'));
    }

    public static function registry(Request $request)
    {
        $body = $request->all();
        $userFindedByUsername = User::where('username', $request->input('username'))->first();

        if ($userFindedByUsername) {
            return response()->json(['error' => 'User existed'], 400);
        }

        return User::create($body);
    }

    public static function me(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user) {
            $user['role'] = Role::where("id", "=", $user['role_id'])->get()->first();
        }
        return $user;
    }

    public static function logout(Request $request)
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
