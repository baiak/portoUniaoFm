<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;   

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
return $schema->schema([
            Section::make('Visual do Banner')
                ->schema([
                    FileUpload::make('imagem_path')
                        ->label('Imagem do Banner')
                        ->image()
                        ->directory('banners')
                        ->imageEditor()
                        ->imageCropAspectRatio('16:9')
                        ->visibility('public')
                        ->required(),
                    
                    TextInput::make('titulo')
                        ->label('Título'),
                        
                    TextInput::make('link_url')
                        ->label('URL')
                        ->url(),
                ])
        ]);
    }
}
