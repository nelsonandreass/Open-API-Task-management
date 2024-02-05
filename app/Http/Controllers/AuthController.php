<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        $user = User::create( [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($user);
    }

    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        $cred = request(['email','password']);
        if(!auth()->attempt($cred)){
            return response()->json(['errorCode' => "401" , 'errorMessage' => "Unauthorized"] , 401);
        }
        $user = User::where('email' , $request->email)->first();
        $authToken = $user->createToken('auth-token')->plainTextToken;
        return response()->json(['access_token' => $authToken]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json(['errorCode'=>'200','errorMessage'=>'Logged out']);
    }
}
