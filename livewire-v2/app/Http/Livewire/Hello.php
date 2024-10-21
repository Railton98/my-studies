<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Hello extends Component
{
    public ?string $text = '';

    public ?User $user = null;

    protected array $rules = [
        'text' => ['required', 'min:3']
    ];

    public function render()
    {
        info(__METHOD__);
        return view('livewire.hello', [
            'user' => $this->user,
        ]);
    }

    public function boot()
    {
        info(__METHOD__);
    }

    public function booted()
    {
        info(__METHOD__);
    }

    public function mount()
    {
        $this->user = auth()->user();
        info(__METHOD__);
    }

    public function hydrate()
    {
        info(__METHOD__);
    }

    public function dehydrate()
    {
        info(__METHOD__);
    }

    public function updating()
    {
        info(__METHOD__);
    }

    public function updated($property)
    {
        $this->validateOnly($property);

        info(__METHOD__);
    }
}
