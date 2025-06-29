<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
   public function store(CommentStoreRequest $request){

     if(!post->published){
       return response()->json([
        'message' => 'No comments can be made on this post'
       ], 403);
     }
       $comment = $post->comment()->create([
        'content' => $request->content,
        'user_id' => $request->user()->id,
       ]);

       return response()->json([
        'message' => 'Comment added successfully',
        'comment' => $comment->load('user::id, name'),
       ]);

   }

   public function destroy(Request $request){
      if($comment->user_id !== auth()->id()){
        return response()->json([
            'message' => 'Not Authorized to delete this comment'
        ],403);
      }

      $comment->delete();
       return response()->json([
        'message' => 'Comment deleted successfully',

       ]);
   }

}