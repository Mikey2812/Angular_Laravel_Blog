<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;


class UsersController extends Controller
{
    public function login (Request $request) {
        $data =  $request->all();
        $userExist = User::where('email', $request->email)->first();
        if(is_null($userExist)){
            $response['message'] = 'Email khong ton tai';
        }
        else {
            if(password_verify($data['password'], $userExist->password)) {
                $payload = [
                    'id' => $userExist->id,
                ];
                $token = JWTAuth::fromUser($userExist, $payload);
                $response['token'] = $token;
                $response['message'] = 'Success';
            }
            else {
                $response['message'] = 'Mat khau khong chinh xac';
            }
        }
        return response()->json($response);
    }

    public function register (Request $request) {
        $data =  $request->all();
        $data['password'] = bcrypt($data['password']);
        $userExist = User::where('email', $request->email)->first();
        if(is_null($userExist)){
            //$data = $usersModal->addUser($data);
            $response['message'] = 'Success';
        }
        else {
            $response['message'] = 'Email da ton tai';
        }
        return response()->json($response);
    }
}