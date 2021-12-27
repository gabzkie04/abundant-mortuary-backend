<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // validate
        $request->validate([
            "name" => "required|unique:users",
            "email" => "required|email|unique:users",
            "role_id" => "required",
            "contact" => "required",
            "gender" => "required",
            "password" => "required|confirmed",
        ]);

        // create user data + save
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->gender = $request->gender;
        $user->birthdate = $request->birthdate;
        $user->role_id = $request->role_id;
        $user->password = bcrypt($request->password);

        $user->save();

        // send response
        return response()->json([
            "status" => 1,
            "message"=> "User registered successfully",
        ], 200);
    }

    public function login(Request $request)
    {
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // verify user + token
        if(! $token = auth()->attempt(["email" => $request->email, "password" => $request->password]))
        {
            return response()->json([
                "status" => 0,
                "message" => "Invalid Credentials"
            ], 404);
        }


        // send response
        return response()->json([
            "status" => 1,
            "message" => "Logged in successfully",
            "data" => array(
                "userInfo" => auth()->user(),
                "access_token" => $token
            )
        ]);
    }

    public function profile()
    {
        $profile = User::select('users.id','name','email','role')
        ->where("users.id", auth()->user()->id)
        ->leftJoin('roles', function($join)
        {
           $join->on('users.role_id', '=', 'roles.id');
        })->first();

        return response()->json([
            "status" => 1,
            "message" => "Data Found",
            "data" => $profile
        ], 200);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            "status"=> 1,
            "message"=> "User logged out"
        ]);
    }
}
