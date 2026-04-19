<?php

namespace App\Filament\Admin\Resources\Brands\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BrandForm
{
    private static function imageOptions(): array
    {
        return collect(File::files(public_path('images')))
            ->filter(fn ($file) => in_array($file->getExtension(), ['svg', 'png', 'jpg', 'jpeg', 'gif', 'webp', 'ico']))
            ->mapWithKeys(fn ($file) => [
                $file->getFilename() =>
                    '<div style="background-color:rgba(0,0,0,0.25);backdrop-filter:blur(8px);border-radius:0.5rem;padding:0.5rem;display:inline-flex;align-items:center;margin-right: 20px;">
                        <img src="/images/'.$file->getFilename().'" style="height:3.5rem;width:3.5rem;display:inline-block;margin-right:0;object-fit:contain;vertical-align:middle">
                    </div>'.$file->getFilename(),
            ])
            ->toArray();
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Identità Brand')
                    ->key('brand-identity::section')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', self::safeSlug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('logo_path')
                            ->options(fn () => self::imageOptions())
                            ->allowHtml()
                            ->searchable()
                            ->label('Logo'),
                        Select::make('colored_logo_path')
                            ->options(fn () => self::imageOptions())
                            ->allowHtml()
                            ->searchable()
                            ->label('Logo colorato'),
                    ])
                    ->columns(2),
                Section::make('Colori')
                    ->key('brand-colors::section')
                    ->schema([
                        ColorPicker::make('primary_color')
                            ->label('Colore primario'),
                        ColorPicker::make('secondary_color')
                            ->label('Colore secondario'),
                    ])
                    ->columns(2),
                Section::make('Impostazioni')
                    ->key('brand-settings::section')
                    ->schema([
                        TextInput::make('simulator_url')
                            ->label('Url simulatore conto termico'),
                        Select::make('pdf_path')
                            ->options(
                                collect(File::files(public_path('pdfs')))
                                    ->filter(fn ($file) => $file->getExtension() === 'pdf')
                                    ->mapWithKeys(fn ($file) => [$file->getFilename() => $file->getFilename()])
                                    ->toArray()
                            )
                            ->searchable()
                            ->label('PDF'),
                        Toggle::make('is_active')
                            ->label('Attivo')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    private static function safeSlug(?string $string): string
    {
        if ($string === null || $string === '') {
            return '';
        }

        try {
            return Str::slug($string);
        } catch (\TypeError) {
            return strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $string));
        }
    }
}
