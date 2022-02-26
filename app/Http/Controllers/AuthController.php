<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function index()
    {
        $user = User::all();

        return response()->json([
            'Users' => $user
        ], Response::HTTP_ACCEPTED);
    }

    public function register(Request $request)
    {

        // body te ashtese naki eita dekhtese!
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);


        // if the user exists in our db or not!

        $users = User::where('email', '=', $request->input('email'))->first();


        if ($users) {
            return response()->json([
                'messege' => 'User already exists'
            ], Response::HTTP_CONFLICT);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);



        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'accessToken' => $token
        ], Response::HTTP_CREATED);
    }



    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = Auth::attempt($request->only('email', 'password'));

        if ($user == false) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ]);
        }

        $user = Auth::user();

        /** @var \App\Models\User $user */
        $token = $user->createToken('apiToken')->plainTextToken;



        return response()->json([
            'user' => $user,
            'accessToken' => $token
        ], Response::HTTP_ACCEPTED);
    }

    public function logout(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if (!Auth::user()) {
            return response()->json([
                'message' => 'user not signed in'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        /** @var \App\Models\User $user */

        $token = $user->tokens()->where('id', $request->input('token'))->delete();

        return response()->json([
            'message' => 'Logouted Out',
            'info' => $token
        ], Response::HTTP_ACCEPTED);
    }

    public function User()
    {
        // $request->validate([
        //     'accessToken' => 'required'
        // ]);
        $user = Auth::user();



        return response()->json([
            'user' => $user
        ]);
    }
}
