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
        $comments= $this->comments;
        return [
            'id'=>$this->id,
            'body'=>$this->body,
            'created_at'=>$this->created_at->format('d-m-Y H:i'),
            'updated_at'=>$this->updated_at->format('d-m-Y H:i'),
            'user'=>new UserResource($this->user),
            'group'=>$this->group,
            'attachments'=> PostAttachmentResource::collection($this->attachments),
            'num_of_reactions'=>$this->reactions->count(),
            // 'num_of_comments'=>$this->comments->count(),
            'num_of_comments'=>count($comments),
            'has_reaction'=>$this->reactions->count() > 0,
            'comments'=>self::convertCommentsToTree($comments)
            // 'comments'=>CommentResource::collection($this->comments->take(5))
        ];
    }

    public function convertCommentsToTree($comments , $parentId=null, ):array{
        $commentTree=[];
        foreach ($comments as $comment) {
            if($comment->parent_id === $parentId){
                $children= self::convertCommentsToTree($comments, $comment->id);
                if($children){
                    $comment->childComments=$children;
                }
                $commentTree[]= new CommentResource($comment);
            }
        }
        return  $commentTree;
    }
}
