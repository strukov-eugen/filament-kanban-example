@php
    $completedTasks = \App\Models\Task::whereHas('users', fn ($query) => $query->where('id', auth()->id()))
        ->where('status', 'done')
        ->count();

    $totalTasks = \App\Models\Task::whereHas('users', fn ($query) => $query->where('id', auth()->id()))->count();
@endphp

<div class="mr-4 text-sm text-gray-500">
    Выполненные задачи: <strong>{{ $completedTasks }} / {{ $totalTasks }}</strong>
</div>