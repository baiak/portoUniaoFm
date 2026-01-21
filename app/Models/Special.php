<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $fillable = [
        'title', 
        'slug', 
        'cover_url', 
        'playlist_html'
        ];
}
