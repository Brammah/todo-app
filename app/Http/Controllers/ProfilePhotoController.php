<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilePhotoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        $user = auth()->user();

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $filename = "XaYPfty10" . $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/photos', $filename);

            $user->photo = $filename;
            $user->save();

            return redirect()->back()->with('message', 'Profile Photo updated.');
        }
        return redirect()->back()->withErrors(['photo' => 'Please upload an image.']);
    }
}
