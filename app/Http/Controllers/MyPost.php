<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyPost extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
      try {
            $vali = $req->validate([
                'user_id'=> 'required|exists:usersPosts,user_id'
            ]);

            $data = DB::table('usersPosts')
                ->where('user_id', $vali['user_id'])
                ->get();

            return response()->json([
                'message'=>'Fetched posts successfully',
                'posts'=>$data,
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
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
                'url'=> $vali['image'] ?? 'noImage',
            ]);

            return response([
                'message'=> 'Post created successfully',
                'postId'=>$postId,
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

  
    public function update(Request $req , $postId)
    {
      try {

       
            $vali = $req->validate([
                'title'=> 'sometimes|string|max:50',
                'des'=> 'sometimes|string',
                'image'=>'nullable|string',
                
            ]);

            $updateData = collect($vali)->toArray();
 
            DB::table('usersPosts')
                ->where('postID', $postId)
                ->update($updateData);

            return response()->json([
                'message'=> 'Post updated successfully',
                'updatedFields' => $updateData
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

    
    public function destroy(string $id)
    {
        try {
         $isAvilible=    DB::table('usersPosts')->where('postID',$id)->delete();
        if($isAvilible){
  return response()->json([
                'message'=>'Post deleted successfully',
                'did_deleted'=>true,

            ]);
        } else {
              return response()->json([
                'message'=>'Wrong Id',
                'did_deleted'=>false,
            ]);
        }
          

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
