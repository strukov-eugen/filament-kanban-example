<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Livewire\Livewire;

class ListLivewireComponents extends Command
{
    protected $signature = 'livewire:list';
    protected $description = 'List all registered Livewire components';

    public function handle()
    {
        $components = Livewire::getComponentClasses();

        foreach ($components as $alias => $class) {
            $this->info("Alias: {$alias}, Class: {$class}");
        }
    }
}