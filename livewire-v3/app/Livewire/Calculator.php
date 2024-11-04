<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Calculator extends Component
{
    public int $num1 = 0;

    public int $num2 = 0;

    public string $operator = '+';

    public ?float $result = null;

    public ?string $keydown = null;

    public function calculate(): void
    {
        sleep(1);
        $tmp = "{$this->num1}{$this->operator}{$this->num2};";

        $this->result = eval('return '.$tmp);
    }

    public function notY(): void
    {
        $this->keydown = str($this->keydown)->replace('y', 'JERERE');
    }

    public function add10(string $prop): void
    {
        $this->$prop += 10;
    }

    #[Renderless]
    public function logging(): void
    {
        Log::info('logando... '.now()->timestamp);
    }

    public function render(): View
    {
        return view('livewire.calculator');
    }
}
