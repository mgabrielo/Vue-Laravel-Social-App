<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostAttachmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'body'=>$this->body,
            'created_at'=>$this->created_at->format('d-m-Y H:i'),
            'updated_at'=>$this->updated_at->format('d-m-Y H:i'),
            'user'=>new UserResource($this->user),
            'group'=>$this->group,
            'attachments'=> PostAttachmentResource::collection($this->attachments),
            'num_of_reactions'=>$this->reactions->count(),
            'num_of_comments'=>$this->comments->count(),
            'has_reaction'=>$this->reactions->count() > 0,
            'comments'=>CommentResource::collection($this->comments->take(5))
        ];
    }
}
