<?php

namespace App\Http\Controllers\auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class login extends Controller
{

//? login

// just for test
public function login(Request $request)
{
    try {
       
        $validated = $request->validate([
             
            'email' => 'required|email:unique:users,email',
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


//? create account 

public function  createUser(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',   
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'=>'required|string'
        ]);
        
       
        $token= Str::random(40);
     $userId =    DB::table('users')->insertGetId([
           'name' => $validated['name']?? 'yasir',
           'email' => $validated['email'],
           'password' => Hash::make($validated['password']),
           'created_at' => now(),
           'updated_at' => now(),       
           'token'=> $token

            
        ]);

        return response()->json([
            'message' => 'User created successfully',
            "userID"=> $userId,
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


// ? delete User


public function deleteUser(Request $request)
{
    try {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        $deleted = DB::table('users')->where('email', $validated['email'])->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'User deleted successfully.'
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }
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
  
 


}