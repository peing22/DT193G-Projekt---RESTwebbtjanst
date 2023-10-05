<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    // Registerar användare
    public function register(Request $request)
    {
        // Validerar
        $validatedUser = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8'
            ]
        );

        // Om validering fallerar
        if ($validatedUser->fails()) {

            // Returnerar felmeddelande
            return response()->json(['message' => 'Validation error', 'error' => $validatedUser->errors()], 401);
        }

        // Skapar användare och krypterar lösenord
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);

        // Lagrar meddelande och användare i variabel
        $response = [
            'message' => 'Created user',
            'user' => $user
        ];

        // Returnerar respons
        return response($response, 201);
    }

    // Loggar in användare
    public function login(Request $request)
    {
        // Validerar
        $validatedUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        // Om validering fallerar
        if ($validatedUser->fails()) {
            
            // Returnerar felmeddelande
            return response()->json(['message' => 'Validation error', 'error' => $validatedUser->errors()], 401);
        }

        // Om felaktiga inloggningsuppgifter
        if (!auth()->attempt($request->only('email', 'password'))) {

            // Returnerar felmeddelande
            return response()->json(['message' => 'Wrong email and/or password'], 401);
        }

        // Lagrar användare i variabel
        $user = User::where('email', $request->email)->first();

        // Returnerar meddelande och API-token
        return response()->json([
            'message' => 'Logged in',
            'token' => $user->createToken('APITOKEN')->plainTextToken,
            'name' => $user->name
        ], 200);
    }

    // Loggar ut användare
    public function logout(Request $request)
    {
        // Raderar API-token
        $request->user()->currentAccessToken()->delete();

        // Lagrar meddelande i variabel
        $response = [
            'message' => 'Logged out'
        ];

        // Returnerar respons
        return response($response, 200);
    }
}
