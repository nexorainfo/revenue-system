<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('admin.profile.profile');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        if ($request->hasFile('profile_photo_path') && $request->user()->profile_photo_path) {
            $this->deleteFile(request()->user()->profile_photo_path);
        }


        $request->user()->update($request->validated());

        toast('प्रोफाइल सफलतापूर्वक अद्यावधिक गरियो', 'success');

        return back();
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request->user()->update($request->validated());

        toast('पासवर्ड सफलतापूर्वक परिवर्तन गरियो', 'success');

        return back();
    }
}
