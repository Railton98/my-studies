<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    #[Locked]
    public ?int $id = null;

    #[Rule(['required', 'string', 'max:255', 'min:2'])]
    public string $name;

    #[Rule(['required', 'email', 'max:255'])]
    public string $email;

    #[Rule(['required', 'confirmed', 'min:6', 'max:10'])]
    public string $password;

    public string $password_confirmation;

    public function save(): void
    {
        $this->validate();

        User::query()->updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
            ]
        );
    }
}
