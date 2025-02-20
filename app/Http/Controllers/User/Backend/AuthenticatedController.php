<?php

namespace App\Http\Controllers\User\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{
    public function postRegister (Request $request)
    {
        $signupCredential = $request->validate([
            'email' => 'email|required',
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'password' => 'confirmed|required'
        ]);
        
        if(User::where('email',$signupCredential['email'])->first()){
            return response()->json(['error'=>'Email is already registered'], 400,);
        }

        if(User::create($signupCredential)){
            return response()->json([], 200);
        } else {
            return response()->json([], 400);
        }
    }

    public function postLogin(Request $request)
    {
        if(Auth::guard('web')->check()){
            return response()->json([], 200);
        }
    
        $loginCredential = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if(Auth::guard('web')->attempt($loginCredential)){
            $request->session()->regenerate();
            return response()->json([], 200);
        } else {
            return response()->json([], 400);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([], 200);
    }
}
