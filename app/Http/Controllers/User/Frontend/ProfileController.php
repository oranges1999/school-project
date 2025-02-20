<?php

namespace App\Http\Controllers\User\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return inertia('User/Profile/Index');
    }
}
