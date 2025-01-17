<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Mokhosh\FilamentKanban\Concerns\HasRecentUpdateIndication;
use App\Models\User;

class Task extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasRecentUpdateIndication;

    protected $guarded = [];

    // App\Models\Task.php
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

}
