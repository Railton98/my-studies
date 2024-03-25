<?php

declare(strict_types=1);

namespace App\Livewire\Tasks;

use App\Models\Task;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tasks')]
class TaskIndex extends Component
{
    public $tasks;

    #[Rule(['required', 'max:10', 'string'])]
    public $name;

    public function mount(): void
    {
        // $this->tasks = Task::with('user')->get();
    }

    public function hydrate()
    {
        // dd('OK');
    }

    public function boot()
    {
        $this->tasks = Task::with('user')->get();
    }

    public function updating()
    {
        //
    }

    public function updated()
    {
        //
    }

    public function rendering($view, $data)
    {
        $data['name'] = 'Tecks';
        // dd($data);
    }

    public function rendered($view, $html)
    {
        // dd($html);
    }

    public function dehydrate()
    {
        // $this->tasks = $this->tasks->toArray();
        // dd($this->tasks);
    }

    public function save(): void
    {
        $this->validate();

        Task::query()->create([
            'user_id' => 1,
            'name' => $this->name,
        ]);

        session()->flash('message', 'Task sucessfully created');

        $this->dispatch('task-updated');

        $this->redirect(route('tasks.index'));
    }

    public function render(): View|Factory
    {
        return view('livewire.tasks.task-index')
            ->with(['button' => 'New Task']);
    }
}
