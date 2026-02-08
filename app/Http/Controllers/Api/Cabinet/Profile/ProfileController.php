<?php

namespace App\Http\Controllers\Api\Cabinet\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Http\Helpers\Upload;
use Avatar;

use App\User;

class ProfileController extends Controller
{
    public function getAuthUser ()
    {
        return Auth::user();
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateAuthUser (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
            'city' => 'required|string',
            'phone' => 'required|string'
        ]);

        $user = User::find(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->last_name = $request->last_name;
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->save();

        $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
        Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);

        return $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePasswordAuthUser(Request $request)
    {
        $this->validate($request, [
            'current' => 'required|string',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string'
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current, $user->password)) {
            return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }

    public function uploadAvatarAuthUser(Request $request)
    {
        $upload = new Upload();
        $avatar = $upload->upload($request->file, 'avatars/'.Auth::id())->resize(200, 200)->getData();

        $user = User::find(Auth::id());
        $user->avatar = $avatar['basename'];
        $user->save();

        return $user;
    }

    public function removeAvatarAuthUser()
    {
        $user = User::find(Auth::id());
        $user->avatar = 'avatar.png';
        $user->save();

        return $user;
    }
}
