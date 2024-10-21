<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Hello extends Component
{
    public ?string $text = '';

    public ?User $user = null;

    protected array $rules = [
        'text' => ['required', 'min:3']
    ];

    public function render(): View
    {
        ds(__METHOD__);
        return view('livewire.hello', [
            'user' => $this->user,
        ]);
    }

    public function boot(): void
    {
        ds(__METHOD__);
    }

    public function booted(): void
    {
        ds(__METHOD__);
    }

    public function mount(): void
    {
        $this->user = auth()->user();
        ds(__METHOD__);
    }

    public function hydrate(): void
    {
        ds(__METHOD__);
    }

    public function dehydrate(): void
    {
        ds(__METHOD__);
    }

    public function updating(): void
    {
        ds(__METHOD__);
    }

    public function updated($property): void
    {
        $this->validateOnly($property);

        ds(__METHOD__);
    }
}
