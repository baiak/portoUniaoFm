<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatedSong extends Model
{
    protected $fillable = ['artist', 'title', 'cover_url', 'likes', 'dislikes'];
}
