<?php

namespace App\Http\Controllers\User\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticatedController extends Controller
{
    public function login()
    {
        return inertia('User/Auth/Login');
    }

    public function register()
    {
        return inertia('User/Auth/Register');
    }
}
