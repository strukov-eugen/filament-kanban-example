<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use App\Enums\TaskStatus;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    //protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';


    protected static ?string $navigationLabel = 'Tasks';
    protected static ?string $pluralModelLabel = 'Tasks';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\Checkbox::make('urgent'),
                Forms\Components\TextInput::make('project')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('due_date')
                    ->required(),
                Forms\Components\TextInput::make('progress')
                    ->numeric()
                    ->required()
                    ->rule('min:0')
                    ->rule('max:100')
                    ->placeholder('Enter progress (0-100)'),
                Forms\Components\Select::make('status')
                    ->options([
                        'todo' => 'To Do',
                        'in_progress' => 'In Progress',
                        'done' => 'Done',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('order_column')
                    ->numeric()
                    ->required(),
                    // Поле для связи с пользователями
                Forms\Components\BelongsToManyMultiSelect::make('users')
                    ->relationship('users', 'name') // Отображение имени пользователя
                    ->label('Assigned Users')
                    ->required(), // Если связь обязательна
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\BooleanColumn::make('urgent'),
                Tables\Columns\TextColumn::make('project'),
                Tables\Columns\TextColumn::make('due_date')
                    ->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress (%)'),
                Tables\Columns\TextColumn::make('status')
                ->formatStateUsing(fn (string $state): string => TaskStatus::from($state)->getTitle()),
                // Колонка для отображения пользователей
                Tables\Columns\BadgeColumn::make('users')
                ->label('Assigned Users')
                ->getStateUsing(function ($record) {
                    return $record->users->pluck('name')->join(', ');
                }),
            ])
            ->filters([
                // Добавьте фильтры, если нужно
            ])
            ->defaultSort('order_column');
    }

    public static function getRelations(): array
    {
        return [
            // Определите менеджеры отношений, если нужно
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}