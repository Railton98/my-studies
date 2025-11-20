<?php

namespace App\Livewire\Media;

use App\Livewire\Forms\ContentForm;
use App\Models\Content;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditContent extends Component
{
    use WithFileUploads;

    public string $labelButton = 'Atualizar Conteúdo';

    public int $contentId;

    public ContentForm $form;

    public function mount(Content $content): void
    {
        $this->contentId = $content->id;
        $this->form->setContent($content);
    }

    public function save()
    {
        if ($this->form->update($this->contentId)) {
            session()->flash('success', 'Conteúdo atualizado com sucesso!');

            return to_route('media.contents.index');
        }
    }

    public function render(): View
    {
        return view('livewire.media.form');
    }
}
