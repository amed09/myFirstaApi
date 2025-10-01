<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\login;
use App\Http\Controllers\UserPost;

 

 

// Example route for creating user
 

Route::post('/login', [login::class,'login']);
Route::post('/craeteUser', [login::class,'createUser']);
Route::post('/deletUser', [login::class,'deleteuser']);
Route::post('/createPost', [UserPost::class,'createPost']);








