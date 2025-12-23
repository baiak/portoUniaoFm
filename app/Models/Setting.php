<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\FileUpload;

class Setting extends Model
{
  use HasFactory;   //
  protected $fillable = [
        'logo_path',
        'radio_name',
        'slogan',
        'frequency',
        'streaming_url',
        'contact_email',
        'whatsapp_number',
    ];
}
