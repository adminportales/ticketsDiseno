<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateStatus(Request $request, User $user)
    {
        $user->profile->update([
            'availability' => $request->status
        ]);
        return response()->json($user);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update_profile(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $filename = Auth::id() . '_' . time() . '.' . $request->photo->getClientOriginalExtension();
        $request->photo->move(public_path('storage/photos'), $filename);

        $user = User::find(auth()->user()->id);
        $user->profile->photo = $filename;
        $user->save();

       # return redirect()->route('user.profile');
    }
}
