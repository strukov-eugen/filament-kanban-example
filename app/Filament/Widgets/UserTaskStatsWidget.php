<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Task;

class UserTaskStatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.user-task-stats-widget';

    public function getStats(): array
    {
        $totalTasks = Task::whereHas('users', fn ($query) => $query->where('id', auth()->id()))->count();
        $completedTasks = Task::whereHas('users', fn ($query) => $query->where('id', auth()->id()))
            ->where('status', 'done')
            ->count();

        return [
            'total' => $totalTasks,
            'completed' => $completedTasks,
        ];
    }
}