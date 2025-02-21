<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{






    public function show()
{
    $user = Auth::user(); 
    ////Посты снизу 
    $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

    return view('profile.show', compact('user', 'posts')); 
}



    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z\s-]+$/',
            'last_name' => 'required|regex:/^[a-zA-Z\s-]+$/',
            'login' => 'required|unique:users,login,' . $user->id . '|regex:/^[a-zA-Z]+$/',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->login = $request->login;
        $user->save();

        $userInfo = UserInfo::where('user_id', $user->id)->first();

        if ($userInfo) {
            $userInfo->first_name = $request->first_name;
            $userInfo->last_name = $request->last_name;

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('/avatars'), $filename);
                $userInfo->avatar = 'avatars/' . $filename; // Убедитесь, что путь правильный

            }

            $userInfo->save();
        } else {
             // If UserInfo does not exist, create a new record.
             $userInfo = new UserInfo([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('/avatars'), $filename);
                $userInfo->avatar = '/avatars' . $filename;
            }
             $userInfo->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Incorrect old password']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully');
    }

    public function delete()
    {
        $user = Auth::user();

        if($user){
            $user->delete();
            return redirect('/')->with('success', 'Profile deleted successfully');
        } else {
            return redirect('/')->with('error', 'User not found');
        }

    }

}
