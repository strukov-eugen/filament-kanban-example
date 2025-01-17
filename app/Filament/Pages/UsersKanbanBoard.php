<?php

namespace App\Filament\Pages;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class UsersKanbanBoard extends KanbanBoard
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $recordTitleAttribute = 'name';

    protected static string $model = User::class;

    protected static string $statusEnum = UserStatus::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Убирает страницу из навигации
    }

    protected function getViewData(): array
    {
        // Получаем записи пользователей
        $records = $this->records();

        // Получаем статусы
        $statuses = $this->statuses()
            ->map(function ($status) use ($records) {
                // Добавляем записи для каждого статуса
                $status['records'] = $this->filterRecordsByStatus($records, $status);

                // Например, можем ограничить количество записей в каждом статусе
                $status['records'] = array_slice($status['records'], 0, 10); // Макс. 10 записей

                return $status;
            });

        // Возвращаем данные для представления
        return [
            'statuses' => $statuses,
        ];
    }
}
