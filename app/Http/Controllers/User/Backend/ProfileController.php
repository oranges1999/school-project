<?php

namespace App\Http\Controllers\User\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function updateProfile(User $user, Request $request)
    {
        $updateData = $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        $user->update($updateData);
        return response()->json([], 200);
    }

    public function updatePassword(User $user, Request $request)
    {
        $passwordData = $request->validate([
            'old_password' => 'required|current_password:web',
            'new_password' => 'required|different:old_password|confirmed:confirm_password',
        ]);

        $user->update([
            'password' => $passwordData['new_password']
        ]);
        return response()->json([], 200);
    }
}
