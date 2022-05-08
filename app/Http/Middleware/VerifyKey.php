<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyKey
{

    public function handle(Request $request, Closure $next)
    {

        if($request->api_password !==env('CHECK_PASSWORD','pYcRoqwvPTxLKEjJSN5')) {

            return response()->json(['message' => 'Unauthenticated']);
        }
            return $next($request);

    }
}
