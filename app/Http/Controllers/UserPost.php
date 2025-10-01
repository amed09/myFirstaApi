<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
class UserPost extends Controller
{
    
 public function createPost(Request $req){
       
//? wllah bjeeeeet az
try {
        $vali = $req->validate([
        'userId'=> 'required|int|exists:users,id',
        'title'=> 'required|string|max:50',
        'des'=> 'required|string',
        'image'=>'nullable|string'
      ]);
  $postId  = (int)(microtime(true) * 1000000);
      DB::table('usersPosts')->insert([
        'postID'=>  $postId,
        'user_id'=> $vali['userId'],
        'title'=> $vali['title'],
        'des'=> $vali['des'],
        'url'=> $vali['image']??'noImage',
      ]);
      return response([
           'message'=> 'succesfully been posted',
           'postId'=>$postId,
      ]);



}catch (\Illuminate\Validation\ValidationException $e) {
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
