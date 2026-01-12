<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongVote extends Model
{
    protected $fillable = ['rated_song_id', 'visitor_id', 'vote_type'];
}
