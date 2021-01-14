<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware("auth:api", ["except"=>["login", "register"]]);
    }

    public function login(Request $request){

        $this->validate($request, [
            "email"=>"required|email",
            "password"=>"required|string|min:6"
        ]);
        $credentials = $request->only(['email', 'password']);
        $tokenValidity = 24*60;
        $this->guard()->factory()->setTTl($tokenValidity);
        if(!$token = $this->guard()->attempt($credentials)){
            return response()->json(["error"=>"Unauthorized"], 401);
        }
        return $this->respondWithToken($token);
    }

    public function register(Request $request){
        $this->validate($request, [
            "name" => "required|string|between:2,100",
            "email" => "required|email|unique:users",
            "password" => "required|min:6"
        ]);
        $user = $request->only(['name', 'email', 'password']);
//        dd(array_merge(
//            $user,
//            ["password"=> Hash::make($request->password)]
//        ));
        $user = User::create(array_merge(
            $user,
            ["password"=> Hash::make($request->password)]
        ));
        return response()->json(["message"=>"User created successfully", "user"=>$user]);
    }

    public function logout(Request $request){
        $this->guard()->logout();

        return response()->json(["message"=>"User logged out successfully"]);
    }

    public function profile(Request $request){
        $user = $this->guard()->user();
        $user->roles = $user->roles()->get();
        return response()->json($user);
    }

    public function refresh(Request $request){
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function guard(){
        return Auth::guard();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            "token"=> $token,
            "token_type"=> "bearer",
            "token_validity"=> $this->guard()->factory()->getTTl() * 60,
        ]);
    }
}
