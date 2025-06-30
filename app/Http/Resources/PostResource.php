<?php
namespace App\Http\Resources;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
  public function toArray(Request $request): array { 
    return [
      'id' => $this->id,
      'title' => $this->title,
      'content' => $this->content,
      'published' => $this->published,
      'user' => [
        'id' => $this->user->id,
        'name' => $this->user->name,
      ],

  'comments' => CommentResource::collection($this->comments),

            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
          ];
        }
}
