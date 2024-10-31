<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Counter extends Component
{
    #[Locked]
    public int $counter = 0;

    public string $name = 'John';
    public string $lastName = 'Doe';

    public function mount(): void
    {
        $this->counter = 100;

        $this->fill([
            'name' => 'Railton',
            'lastName' => 'L Rodrigues',
        ]);
    }

    public function render(): View
    {
        return view('livewire.counter');
    }

    public function refresh(): void
    {
        $this->reset('name', 'lastName');
    }
}
