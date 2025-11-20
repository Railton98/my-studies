<?php

namespace App\Livewire\Media;

use App\Models\Content;
use Illuminate\View\View;
use Livewire\Component;

class RemoveContent extends Component
{
    public int $contentId;

    public function mount(int $contentId)
    {
        $this->contentId = $contentId;
    }

    public function remove(): void
    {
        Content::query()
            ->findOrFail($this->contentId)
            ->delete();

        $this->dispatch("content_removed_{$this->contentId}");
    }

    public function render(): View
    {
        return view('livewire.media.remove-content');
    }
}
