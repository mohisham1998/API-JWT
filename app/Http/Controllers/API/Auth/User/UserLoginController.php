<?php

namespace App\Http\Controllers\API\Auth\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserLoginController extends Controller
{

    use ApiTrait;

    public function login(Request $request) {

        $rules = [
            "email" => "required",
            "password" => "required"
        ];
        $validator = Validator::make($request->all(), $rules);
        try {

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $credentials = $request -> only(['email','password']);


            $token = Auth::guard('user-api')->attempt($credentials);

            if(!$token) {
                return  $this -> returnError(123,'Invalid credentials');
            }

            $user = Auth::guard('user-api') -> user();
            $user -> token = $token;
            return $this->returnData('admin',$user,"Success!!");
        }

        catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }


    public function logout(Request $request) {

        $token = $request->header('auth-token');
        try {
            if($token) {
                JWTAuth::setToken($token) ->invalidate();
                return $this -> returnSuccessMessage("Logged out successfully");
            }

            else {
                return $this -> returnError(1234,"Something went wrong..");
            }
        }

        catch (\Exception $ex) {
            return $this -> returnError(1234,"Something went wrong..");
        }

    }

}
