<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
       $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        $tokenValue = Str::random(60);

        $expiresAt = Carbon::now()->addHour();


        $apiToken = ApiToken::create([
            'user_id'    => $user->id,
            'token'      => $tokenValue,
            'expires_at' => $expiresAt,
            'username'   => $user->email,
        ]);

        return response()->json([
            'token'      => $apiToken->token,
            'expires_at' => $apiToken->expires_at->toDateTimeString(),
            'user'       => [
                'id'    => $user->id,
                'email' => $user->email
            ]
        ], 200);
    }
}

