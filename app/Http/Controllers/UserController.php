<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:8|max:16'
        ]);
        if ($validate) {
            $email = $request->email;
            $password = $request->password;

            $checkEmail = User::where([
                'email' => $email,
                'is_active' => 1
            ])->first();

            if ($checkEmail) {
                $checkPassword = Hash::check($password, $checkEmail->password);
                if ($checkPassword) {
                    $checkEmail->token = $checkEmail->createToken($checkEmail->email)->plainTextToken;
                    return response()->json([
                        'data' => $checkEmail,
                        "message" => 'User Found Successfully'
                    ]);
                } else {
                    return response()->json([
                        'data' => [],
                        "message" => 'Password not match'
                    ], 401);
                }
            } else {
                return response()->json([
                    'data' => [],
                    "message" => 'Email not found'
                ], 404);
            }
        }
    }

    public function register(Request $request)
    {
        $email = $request->email;
    }
}
