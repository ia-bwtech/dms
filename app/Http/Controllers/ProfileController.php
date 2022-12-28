<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function update(ProfileUpdateRequest $request)
    {
        if ($request->password) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
        }

        auth()->user()->update([
            'name' => $request->name,
            // 'email' => $request->email,
            'bio' => $request->bio,
        ]);

        return redirect()->back()->with('success', 'Profile updated.');
    }

    public function updateImage(Request $request) {
        if (request()->hasFile('image')) {
            $imageName = auth()->id() . '-' . auth()->user()->name . '-' . request()->file('image')->getClientOriginalName();
            $path = public_path('images/profile');
            request()->file('image')->move($path, $imageName);
            auth()->user()->update(['image' => $imageName]);
        }

        return redirect()->back()->with('success', 'Profile updated.');
    }
}
