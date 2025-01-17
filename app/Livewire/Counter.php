<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class Counter extends Component
{
    public $totalTasks = 0;
    public $completedTasks = 0;

    protected $listeners = ['taskStatusUpdated' => 'updateStats'];

    public function mount()
    {
        $this->updateStats();
    }

    public function updateStats()
    {
        $user = auth()->user();

        $this->totalTasks = Task::whereHas('users', fn ($query) => $query->where('id', $user->id))->count();
        $this->completedTasks = Task::whereHas('users', fn ($query) => $query->where('id', $user->id))
            ->where('status', 'done')
            ->count();
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
