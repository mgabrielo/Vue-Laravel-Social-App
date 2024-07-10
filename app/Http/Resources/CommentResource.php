<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment'=>$this->comment,
            'created_at'=>$this->created_at->format('d-m-Y H:i'), 
            'updated_at'=>$this->updated_at->format('d-m-Y H:i'),
            'user'=>[
                "id"=> $this->user->id,
                "name"=> $this->user->name,
                "username" => $this->user->username,
                "avatar_url" =>$this->user->avatar_path ? Storage::url($this->user->avatar_path) : null,
            ],
            'num_of_comment_reactions'=>$this->reactions->count(),
            'has_comment_reaction'=>  $this->reactions->count() > 0,
        ];
    }
}
