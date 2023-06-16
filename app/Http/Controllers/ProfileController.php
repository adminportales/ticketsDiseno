<?php

namespace App\Http\Controllers;

use App\HistoryAvailability;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateStatus(Request $request, User $user)
    {
        $user->profile->update([
            'availability' => $request->status
        ]);
        HistoryAvailability::create([
            'info' => "El usuario " . auth()->user()->name . " ha cambiado el estado de {$user->name} a " . ($request->status == 0 ? 'Desactivado' : 'Activo'),
            'user_id' => auth()->user()->id
        ]);
        return response()->json($user);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update_profile(Request $request)
    {
        $file = $request->file('photo');
        $imageName = 'photos/' . $file->getClientOriginalName();

        try {
            Storage::disk('local')->put('public/' . $imageName, File::get($file));
        } catch (\Exception $exception) {
            return response('error', 400);
        }

        auth()->user()->profile->update(['photo' => $imageName]);
        return redirect()->back();
    }
}
