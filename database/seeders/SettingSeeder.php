<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    \App\Models\Setting::updateOrCreate(['id' => 1], [
        'radio_name' => 'Porto União FM',
        'slogan' => 'A rádio da nossa gente',
        'frequency' => '87.9 FM',
        'streaming_url' => 'https://stm4.xcast.com.br:12006/stream',
        'contact_email' => 'direcao879@hotmail.com',
        'whatsapp_number' => '(42)99123-3360',
    ]);
}
}
