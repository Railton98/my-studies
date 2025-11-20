<?php

namespace App\Livewire\Media;

use App\Livewire\Forms\ContentForm;
use Illuminate\View\View;
use Livewire\Component;

class CreateContent extends Component
{
    public string $labelButton = 'Criar Conteúdo';

    public ContentForm $form;

    public function save()
    {
        if ($this->form->save()) {
            session()->flash('success', 'Conteúdo criado com sucesso!');

            return to_route('media.contents.index');
        }
    }

    public function render(): View
    {
        return view('livewire.media.form');
    }
}
