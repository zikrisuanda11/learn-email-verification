<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function show()
    {
        $data = User::all();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validation->fails())
        {
            return response()->json($validation->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
            return response()->json([
                'message' => 'email salah'
            ]);
        }
        if(!Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'password salah'
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'success login',
            'token_type' => 'bearer Token',
            'token' => $token
        ],  Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'berhasil logout'
        ], Response::HTTP_OK);
    }
}
