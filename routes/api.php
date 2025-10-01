<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\database\CreateUserWithEmailAndPasswrod;
use App\Http\Controllers\auth\login;
 

 

// Example route for creating user
Route::post('/create-user', [CreateUserWithEmailAndPasswrod::class, 'createUser']);

Route::post('/login', [login::class,'login']);
Route::post('/craeteUser1', [login::class,'createUser']);

