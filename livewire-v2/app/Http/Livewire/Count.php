<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

/**
 * @property-read string $lastName
 */
class Count extends Component
{
    public ?string $name = 'Railton';

    public function render(): View
    {
        return view('livewire.count');
    }

    public function toggle(string $type): void
    {
        if ($type === 'LOWER') {
            $this->name = str($this->name)->lower();
        } else {
            $this->name = str($this->name)->upper();
        }
    }

    public function getLastNameProperty(): string
    {
        return 'Teck\'s';
    }
}
