<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyPost;
use App\Http\Controllers\TeacherPost;
use App\Http\Controllers\auth\login;
// Example route for creating user
// Route::post('/login', [login::class,'login']);
Route::post('/craeteUser', [login::class,'createUser']);
// Route::post('/deletUser', [login::class,'deleteuser']);
 
Route::resource('/posts', MyPost::class);  
Route::post('/create_techer_post',[TeacherPost::class,'createTeacherPost']);
