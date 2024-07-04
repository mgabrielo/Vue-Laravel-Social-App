<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostAttachment extends Model
{
    use HasFactory;
    CONST UPDATED_AT=null;
    protected $fillable=[
        'post_id',
        'name',
        'mime',
        'size',
        'path',
        'created_by',
    ];
}