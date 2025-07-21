<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
    ];
}
