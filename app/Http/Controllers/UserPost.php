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

//? fetchPost 
 public function fetchPost(Request $req){
             
   try {
       $vali = $req->validate([
       'user_id'=> 'required|exists:usersPosts,user_id'
      ]);




      $data =  DB::table('usersPosts')->where('user_id',$vali['user_id'])->get();

       return response()->json([
        'message'=>'bjeeeeet Kurdista',
        'user_id'=>$data,
       ]);


    }  catch (\Illuminate\Validation\ValidationException $e) {
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

  // ? deletPost 
 public function deletPost(Request $req){
   
      
   try {
 $vali= $req->validate([
     'postID'=>'required|exists:usersPosts,postID',
    ]);

       DB::table('usersPosts')->where('postID',$vali['postID'])->delete();
       return response()->json([
      'message'=>'there post has been deleted SuccsesFully',
        
       ]);
   }  catch (\Illuminate\Validation\ValidationException $e) {
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
 










 //? updatePost
     public function updatePost(Request $req){


  try {
        $vali = $req->validate([
        'post_id'=>'required|exists:usersPosts,postID',
        'title'=> 'sometimes|string|max:50',
        'des'=> 'sometimes|string',
        'image'=>'nullable|string'
      ]);
$updateData = collect($vali)->except('post_id')->toArray();
       DB::table('usersPosts')->where('postID',$vali['post_id'])->update($updateData);
       print_r($updateData);
       return response()->json([
        'mesage'=> 'post updated succsefully',
       ]);

  }  
  catch (\Illuminate\Validation\ValidationException $e) {
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
