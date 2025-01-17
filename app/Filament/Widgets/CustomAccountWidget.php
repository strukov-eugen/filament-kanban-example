<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget;
use App\Models\Task;

class CustomAccountWidget extends AccountWidget
{
    protected function getUserAvatarUrl(): ?string
    {
        return auth()->user()->avatar_url; // Если у вас есть поле для аватарки
    }

    protected function getUserName(): string
    {
        $completedTasks = Task::whereHas('users', fn ($query) => $query->where('id', auth()->id()))
            ->where('status', 'done')
            ->count();

        $totalTasks = Task::whereHas('users', fn ($query) => $query->where('id', auth()->id()))->count();

        return auth()->user()->name . " (Выполненные задачи: $completedTasks / $totalTasks)";
    }
}