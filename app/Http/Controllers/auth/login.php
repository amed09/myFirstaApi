<?php

namespace App\Http\Controllers\auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class login extends Controller
{

//? login

// just for test
public function login(Request $request)
{
    try {
        // Validate input
        $validated = $request->validate([
             
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        
        $user = DB::table('users')->where('email', $validated['email'])->first();
        if (!$user) {
            return response()->json([
                'message' => 'Email or Password not found'
            ], 400);
        }

        // Check password
        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Email or Password not found'
            ], 400);
        }

        // Success
        return response()->json([
            'message' => 'Login successful',
            'data' => $validated
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Catch validation errors
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        // Catch all other errors
        return response()->json([
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}


//? create accoutn 

public function createUser(Request $request)
{
    try {
        $validated = $request->validate([
         'name' => 'nullable|string|max:255',   
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        DB::table('users')->insert([
           'name' => $validated['name']?? 'yasir',
           'email' => $validated['email'],
           'password' => Hash::make($validated['password']),
           'created_at' => now(),
           'updated_at' => now(),
            
        ]);

        return response()->json([
            'message' => 'User created successfully'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}


// just for test

}
