<?php

namespace App\Filament\Resources\RadioSettings;

use App\Filament\Resources\RadioSettings\Pages\ManageRadioSettings;
use App\Models\RadioSetting;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;

class RadioSettingResource extends Resource
{
    protected static ?string $model = RadioSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                TextInput::make('slogan'),
                FileUpload::make('logo_path')
                    ->label('Logo da Rádio')
                    ->disk('public') // Salva em storage/app/public
                    ->image() // Garante que apenas imagens sejam aceitas
                    ->directory('radio-brand') // Salva em storage/app/public/radio-brand
                    ->imageEditor() // Permite cortar/ajustar a logo após o upload
                    ->circleCropper() // Opcional: força um corte circular se preferir
                    ->required(),
                TextInput::make('streaming_url')
                    ->label('URL do Streaming')
                    ->url() // Valida se o formato da URL está correto
                    ->placeholder('https://seu-servidor.com:8000/stream'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('slogan')
                    ->searchable(),
                TextColumn::make('logo_path')
                    ->searchable(),
                TextColumn::make('streaming_url')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRadioSettings::route('/'),
        ];
    }
}
