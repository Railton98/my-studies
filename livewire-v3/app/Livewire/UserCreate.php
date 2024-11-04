<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use Illuminate\View\View;
use Livewire\Component;

class UserCreate extends Component
{
    public UserForm $form;

    public function submit(): void
    {

        $this->form->save();
    }

    public function render(): View
    {
        return view('livewire.user-create');
    }
}
