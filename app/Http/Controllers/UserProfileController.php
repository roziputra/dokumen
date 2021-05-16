<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserForm;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('profile', ['user' => $request->user()]);
    }

    public function update(UserForm $request)
    {
        $user = $request->user();
        $validated = $request->validated();
        $data = User::find($user->id);
        $data->update($validated);

        return redirect('/user/profile')->with('message-success', 'Profile updated successfully');
    }

    public function changePassword(UserForm $request)
    {
        $user = $request->user();
        $validated = $request->validated();

        $data = User::find($user->id);
        $data->password = Hash::make($validated['password']);
        $data->save();

        return redirect('/user/profile')->with('message-success', 'Password updated successfully');
    }
}
