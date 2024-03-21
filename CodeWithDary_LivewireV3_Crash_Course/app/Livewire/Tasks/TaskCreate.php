<?php

namespace App\Livewire\Tasks;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Create Task')]
class TaskCreate extends Component
{
    public function render()
    {
        return view('livewire.tasks.task-create');
    }
}
