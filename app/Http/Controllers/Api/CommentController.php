<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentStoreRequest $request, Post $post)
    {
        if (!$post->published) {
            return response()->json([
                'message' => 'No comments can be made on this post'
            ], 403);
        }

        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment->load('user:id,name'),
        ]);
    }


    public function index(Post $post){
        $comments = $post->comments()->with('user:id,name')->get();
        return CommentResource::collection($comments);

    }

     public function show(Comment $comment)
     {
        return new CommentResource($comment->load('user:id,name'));
}

    public function update(CommentStoreRequest $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $comment->update($request->validated());

        return response()->json([
            'message' => 'Comment updated successfully',
            'post' => $comment->load('user:id,name'),
        ]);
    }


    public function destroy(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not authorized to delete this comment'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }
}
