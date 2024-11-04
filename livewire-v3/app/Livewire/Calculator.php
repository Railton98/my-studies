<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class Calculator extends Component
{
    public int $num1 = 0;

    public int $num2 = 0;

    public string $operator = '+';

    public ?float $result = null;

    public function calculate(): void
    {
        $tmp = "{$this->num1}{$this->operator}{$this->num2};";

        $this->result = eval('return '.$tmp);
    }

    public function render(): View
    {
        return view('livewire.calculator');
    }
}
