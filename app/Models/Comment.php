<?php

namespace App\Models;

use App\Models\Post;
use App\Models\CommentReaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    public array $childComments=[];

    protected $fillable=[
        'post_id', 
        'comment', 
        'user_id',
        'parent_id'
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function post():BelongsTo{
        return $this->belongsTo(Post::class);
    }
    public function reactions():HasMany{
        return $this->hasMany(CommentReaction::class);
  }

  public function comments():HasMany{
    return $this->hasMany(self::class, 'parent_id');
  }
}
