<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class UserResume extends Component
{
    #[Rule(['required', 'max:255', 'min:5'])]
    public ?string $resume = null;

    public function mount(): void
    {
        $this->resume = auth()->user()->resume;
    }

    public function updated(string $attr, mixed $value): void
    {
        ds()->queriesOn();
        auth()->user()->update([$attr => $value]);
    }

    public function render(): View
    {
        return view('livewire.user-resume');
    }
}
