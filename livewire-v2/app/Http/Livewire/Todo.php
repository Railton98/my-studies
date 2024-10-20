<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Todo extends Component
{
    public string $name;

    protected $listeners = [
        'mudaai' => 'vai',
    ];

    public function vai(string $value): void
    {
        $this->name = $value;
    }

    public function render(): View
    {
        return view('livewire.todo');
    }
}
