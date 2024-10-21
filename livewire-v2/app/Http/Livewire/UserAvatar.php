<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserAvatar extends Component
{
    use WithFileUploads;

    public $avatar;

    public function save(): void
    {
        $ref = $this->avatar->store('public');

        $user = auth()->user();
        $user->avatar = $ref;
        $user->save();
    }

    public function render(): View
    {
        return view('livewire.user-avatar');
    }
}
