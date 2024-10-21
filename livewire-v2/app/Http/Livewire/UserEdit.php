<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserEdit extends Component
{
    public bool $show = false;

    public ?User $user = null;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render(): View
    {
        return view('livewire.user-edit');
    }

    public function edit(): void
    {
        $this->user->name = fake()->name;
        $this->user->save();

        $this->emitUp('user::updated');

        $this->show = false;
    }
}
