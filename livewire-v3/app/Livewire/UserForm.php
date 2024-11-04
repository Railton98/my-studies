<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class UserForm extends Component
{
    #[Rule(['required', 'string', 'max:255', 'min:2'])]
    public string $name;

    #[Rule(['required', 'email', 'max:255'])]
    public string $email;

    #[Rule(['required', 'confirmed', 'min:6', 'max:10'])]
    public string $password;

    public string $password_confirmation;

    public function submit(): void
    {
        $this->validate();

        User::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }

    public function render(): View
    {
        return view('livewire.user-form');
    }
}
