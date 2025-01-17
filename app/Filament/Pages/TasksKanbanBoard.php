<?php

namespace App\Filament\Pages;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

use Livewire\LivewireManager;

class TasksKanbanBoard extends KanbanBoard
{
    protected static string $model = Task::class;

    protected static string $statusEnum = TaskStatus::class;

    protected static ?string $navigationLabel = 'My Tasks Board';

    // Статическое свойство для хранения LivewireManager
    public static ?LivewireManager $livewire = null;

    // Метод для получения зависимости LivewireManager
    /* public function setLivewireManager($livewire): void
    {
        static::$livewire = $livewire;
    } */

    public function getTitle(): string
    {
        return 'My Tasks Board';
    }

    /**
     * Переопределяем метод records для ограничения количества задач.
     */
    protected function records(): \Illuminate\Support\Collection
    {
        return static::$model::query()
            ->whereHas('users', fn ($query) => $query->where('id', auth()->id()))
            ->when(
                method_exists(static::$model, 'scopeOrdered'),
                fn ($query) => $query->ordered()
            )
            //->limit(50) // Ограничение на 50 записей
            ->get();
    }

    protected function getEditRecordFormSchema(): array
    {
        return [
            MultiSelect::make('users')
                ->relationship('users', 'name') // Связь с пользователями
                ->placeholder('Assign users to this task')
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        // Обновляем статус задачи
        Task::find($recordId)->update(['status' => $status]);

        // Обновляем порядок задач
        Task::setNewOrder($toOrderedIds);

        //static::$livewire->emit('taskStatusUpdated', ['message' => 'updateStats']);

    }

}
