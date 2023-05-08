<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->token;
        // try{
        //     $token = $request->token;
        //     $data = JWTAuth::getPayload($token)->toArray();
        // }
        // catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

        //     return response()->json(['token_expired'], 500);
    
        // } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    
        //     return response()->json(['token_invalid'], 500);
    
        // } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        //     $response = [
        //         'message'=>'Token is required'
        //     ];
        //     return response()->json($response, 500);
    
        // }

        return $next($request);
    }
}