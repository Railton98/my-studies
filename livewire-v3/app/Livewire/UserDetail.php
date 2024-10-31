<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class UserDetail extends Component
{
    public User $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    public function render(): View
    {
        return view('livewire.user-detail');
    }
}
