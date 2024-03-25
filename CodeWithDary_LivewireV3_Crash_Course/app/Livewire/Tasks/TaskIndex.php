<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tasks')]
class TaskIndex extends Component
{
    public $tasks;

    public $name;

    public function mount(): void
    {
        $this->tasks = Task::with('user')->get();
    }

    public function add(): void
    {
        dd($this->name);
    }

    public function render(): View|Factory
    {
        return view('livewire.tasks.task-index')
            ->with(['button' => 'New Task']);
    }
}
