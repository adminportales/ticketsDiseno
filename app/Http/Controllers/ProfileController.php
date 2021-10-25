<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function updateStatus(Request $request, User $user)
    {
        $user->profile->update([
            'availability' => $request->status
        ]);
        return response()->json($user);
    }
}
