<?php

namespace App\Filament\Admin\Resources\Quizzes\Tables;

use App\Enums\Difficulty;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class QuizzesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('is_active'),
                TextColumn::make('difficulty')
                    ->badge()
                    ->formatStateUsing(fn (Difficulty $state) => $state->label()),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Questions'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->hidden(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
