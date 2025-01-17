<div class="p-4 bg-white rounded-lg shadow">
    <h2 class="text-lg font-semibold">
        Выполненные задачи: {{ $this->getStats()['completed'] }} / {{ $this->getStats()['total'] }}
    </h2>
</div>