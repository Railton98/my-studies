<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class UserEdit extends Component
{
    public UserForm $form;

    public User $user;

    public function mount(): void
    {
        $this->form->name = $this->user->name;
        $this->form->email = $this->user->email;
        $this->form->id = $this->user->id;
    }

    public function submit(): void
    {

        $this->form->save();
    }

    public function render(): View
    {
        return view('livewire.user-edit');
    }
}
