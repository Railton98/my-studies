<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserCreate extends Component
{
    public ?string $name = null;

    public ?string $email = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', /* new CustomRule */]
        ];
    }

    public function render(): View
    {
        return view('livewire.user-create');
    }

    public function updated($prop): void
    {
        $this->validateOnly($prop);
    }

    public function save(): void
    {
        $this->validate();

        if ($this->name == 'Rafael') {
            $this->addError('name', 'UUUUU Jeremias!!! Deu ruim nesse nome');
        }
    }
}
