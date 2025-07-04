<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;


class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['user:id,name', 'comments.user:id,name'])
            ->published()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

         return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create(array_merge(
            ['user_id' => auth()->id()],
            $request->validated()
        ));

        return response()->json([
            'message' => 'Post created successfully',
            'post' => new PostResource($post->load('user:id,name')),
        ], 201);
    }

    public function show(Post $post)
    {
        
        if (!$post->published && (!auth()->check() || $post->user_id !== auth()->id())) {
            return response()->json([
                'message' => 'Post Not Found'
            ], 404);
        }

        $post->load(['user:id,name', 'comments.user:id,name']);
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $post->update($request->validated());

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => new PostResource($post->load('user:id,name')),
        ]);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'You are not authorized to delete this'
            ], 403);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
        ]);
    }

    public function myPosts(Request $request)
    {
        $posts = $request->user()->posts()
            ->with('comments.user:id,name')
            ->published()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

       return PostResource::collection($posts);
    }
   
    public function userPost(User $user, Post $post){

       if($post->user_id !== $user->id) {
        return response()->json([
         'message' => 'Post not found for this user'
      ], 404);
        }
      
        $post->load(['user:id,name', 'comments.user:id,name']);

        return new PostResource($post);
    }


}
