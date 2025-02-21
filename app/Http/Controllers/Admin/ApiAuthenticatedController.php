<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthenticatedController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::guard('admin')->check()){
            return response()->json([], 200);
        }
    
        $loginCredential = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if(Auth::guard('admin')->attempt($loginCredential)){
            $request->session()->regenerate();
            return response()->json([], 200);
        } else {
            return response()->json([], 400);
        }
    }
}
