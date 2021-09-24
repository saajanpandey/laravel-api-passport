<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PassportController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

            $token = auth()->user()->createToken('ApiToken')->accessToken;

            return response(['user' => auth()->user(), 'token' => $token], 200);
        } else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->password = Hash::make($request->password);
        $user->save();
        $token = $user->createToken('ApiToken')->accessToken;
        return response()->json(['token' => $token], 200);
    }

    public function showDetails()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
}
