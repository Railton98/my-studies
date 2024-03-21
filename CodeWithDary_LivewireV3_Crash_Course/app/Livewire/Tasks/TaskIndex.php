<?php

namespace App\Livewire\Tasks;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tasks')]
class TaskIndex extends Component
{
    public function render()
    {
        return view('livewire.tasks.task-index');
    }
}
