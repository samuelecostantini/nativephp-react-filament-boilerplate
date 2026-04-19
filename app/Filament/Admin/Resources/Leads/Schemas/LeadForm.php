<?php

namespace App\Filament\Admin\Resources\Leads\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead Information')
                    ->schema([
                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->required(),
                        TextInput::make('first_name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('quiz_result_score')
                            ->hidden()
                            ->numeric()
                            ->default(9)
                            ->disabled(),
                    ])
                    ->columns(2),
            ]);
    }
}
