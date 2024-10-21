<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UsersList extends Component
{
    protected $listeners = [
        'user::updated' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.users-list', [
            'users' => User::query()->get(),
        ]);
    }
}
