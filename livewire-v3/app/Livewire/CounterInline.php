<?php

namespace App\Livewire;

use Livewire\Component;

class CounterInline extends Component
{
    public int $counter = 0;

    public function render(): string
    {
        return <<<'HTML'
        <div>
            Hello from inline!!

            <br>

            Counter:: {{ $counter }}
        </div>
        HTML;
    }
}
