<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;
use Livewire\Livewire;
use App\Filament\Pages\TasksKanbanBoard;
use Livewire\LivewireManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerRenderHook(PanelsRenderHook::TOPBAR_START, function () {
                return Livewire::mount('counter');
            });
        });

        // После создания объекта передаем зависимость LivewireManager
        /*app()->resolving(TasksKanbanBoard::class, function ($tasksKanbanBoard, $app) {
            $tasksKanbanBoard->setLivewireManager($app->make(LivewireManager::class));
        });*/
    }
}
