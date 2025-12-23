<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  use HasFactory;   //
  protected $fillable = [
        'radio_name',
        'slogan',
        'frequency',
        'streaming_url',
        'contact_email',
        'whatsapp_number',
    ];
}
