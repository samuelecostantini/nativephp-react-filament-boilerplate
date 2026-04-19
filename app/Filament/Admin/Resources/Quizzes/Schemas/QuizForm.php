<?php

namespace App\Filament\Admin\Resources\Quizzes\Schemas;

use App\Enums\Difficulty;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuizForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Section::make('Altre impostazioni')->schema([
                            Textarea::make('description')
                                ->rows(1)
                                ->helperText('Brief description of what this quiz is about'),
                            Select::make('difficulty')
                                ->options(Difficulty::class)
                                ->default(Difficulty::Beginner),
                            TextInput::make('time')
                                ->label('Time for questions')
                                ->numeric()
                                ->default(30)
                                ->suffix('sec'),
                            TextInput::make('number_of_questions')
                                ->helperText('Number of questions during game')
                                ->label('Questions per session')
                                ->numeric()
                                ->default(3)
                            ,
                            Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                                ->inline(false),
                        ])->columnSpanFull()
                            ->columns(2)
                        ->collapsible()
                        ->collapsed(),
                    ])
                    ->columns(2),

                Section::make('Questions')
                    ->schema([
                        Repeater::make('questions')
                            ->relationship('questions')
                            ->label('')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('text')
                                            ->label('Question Text')
                                            ->required()
                                            ->columnSpanFull(),
                                        Select::make('type')
                                            ->options([
                                                'single_choice' => 'Single Choice',
                                                'multiple_choice' => 'Multiple Choice',
                                            ])
                                            ->required()
                                            ->default('single_choice')
                                            ->helperText('Single: one answer | Multiple: multiple answers'),
                                        TextInput::make('order')
                                            ->numeric()
                                            ->default(0)
                                            ->helperText('Lower numbers appear first'),

                                        Section::make()
                                            ->label('Answers')
                                            ->schema([
                                                Repeater::make('answers')
                                                    ->relationship('answers')
                                                    ->label('')
                                                    ->schema([
                                                        TextInput::make('text')
                                                            ->label('Answer')
                                                            ->required()
                                                            ->columnSpan(2),
                                                        Toggle::make('is_correct')
                                                            ->label('Correct')
                                                            ->inline(false),
                                                    ])
                                                    ->columns(3)
                                                    ->defaultItems(1)
                                                    ->reorderable()
                                                    ->addActionLabel('Add Answer')
                                                    ->itemLabel(fn (array $state): ?string => $state['text'] ?? null),
                                            ])
                                            ->columns(1)
                                            ->columnSpanFull()
                                            ->collapsible()
                                            ->collapsed(false),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                            ])
                            ->reorderable('order')
                            ->addActionLabel('Add Question')
                            ->itemLabel(fn (array $state): ?string => $state['text'] ?? null)
                            ->collapsed(true),
                    ]),
            ])->columns(1);
    }
}
