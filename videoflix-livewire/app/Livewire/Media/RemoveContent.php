<?php

namespace App\Livewire\Media;

use App\Models\Content;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class RemoveContent extends Component
{
    public int $contentId;

    public function mount(int $contentId)
    {
        $this->contentId = $contentId;
    }

    public function remove()
    {
        $content = Content::query()->findOrFail($this->contentId);

        $disk = Storage::disk('public');
        if ($disk->exists($content->cover)) {
            $disk->delete($content->cover);
        }

        $content->delete();

        session()->flash('success', 'Conteúdo removido com sucesso!');

        return to_route('media.contents.index');
    }

    public function render(): View
    {
        return view('livewire.media.remove-content');
    }
}
