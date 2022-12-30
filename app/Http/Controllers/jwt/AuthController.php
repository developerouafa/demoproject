<?php

namespace App\Http\Controllers\jwt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request){
        // validation
        try{
                $rules = [
                    // "email" => "required|exists:admin_users,email",
                    "email" => "required",
                    "password" => "required"
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

        // login
            $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('api')->attempt($credentials);

            if (!$token)
                return $this->returnError('E001', 'No exist');

            $admin = Auth::guard('api')->user();
            $admin->api_token = $token;

        // return token
            return $this->returnData('admin', $admin);
    }

    public function logout(Request $request)
    {
        $token = $request -> header('auth-token');
        if($token){
            try {
                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','some thing went wrongs');
            }
            return $this->returnSuccessMessage('Logged out successfully');
        }else{
            $this -> returnError('','some thing went wrongs');
        }
    }
}
