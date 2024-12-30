<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiToken;
use Carbon\Carbon;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'message' => 'Missing or invalid Authorization header.'
            ], 401);
        }

        $token = substr($authHeader, 7);

        $tokenRecord = ApiToken::where('token', $token)->first();

        if (!$tokenRecord) {
            return response()->json(['message' => 'Invalid token.'], 401);
        }

        if (Carbon::now()->greaterThan($tokenRecord->expires_at)) {
            return response()->json(['message' => 'Token expired.'], 401);
        }

        // (Optional) We can update expires_at if we want "sliding session"
        return $next($request);
    }
}
