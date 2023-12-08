<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function register(Request $request)
    {

        try {

            $this->validate(
                $request,
                [
                    'username' => 'required|string',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6'
                ],
                [
                    'username.required' => 'Nama harus diisi',
                    'email.required' => 'Email harus diisi',
                    'email.email' => 'Email tidak valid',
                    'email.unique' => 'Email sudah terdaftar',
                    'password.required' => 'Password harus diisi',
                    'password.min' => 'Password minimal 6 karakter',
                ]
            );


            $user = new \App\Models\User;
            $user->username = $request->username;
            $user->email = $request->email;
            // $user->password = app('hash')->make($request->password);
            $user->password = app('hash')->make($request->password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil dibuat',
                'data' => $user
            ], 201);
        } catch (ValidationException $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->errors(),
                'data' => null
            ], 422);
        }
    }

    public function getUser(){
        $user = Auth()->user();
        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil ditampilkan',
            'data' => $user
        ], 200);
    }

    public function logout(){
        $user = Auth::user();

        if ($user) {
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });
        }
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function checkToken(){
        $token = Auth::guard('api')->check();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Check Token',
            'data' => $token
        ], 200);
    }
}
