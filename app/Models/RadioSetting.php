<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadioSetting extends Model
{
    protected $fillable = [
        'nome',
        'slogan',
        'logo_path',
        'streaming_url',
    ];
}
