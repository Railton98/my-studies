<?php

namespace App\Livewire\Media;

use App\Models\Content;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class IndexContent extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.media.index-content', [
            'contents' => Content::query()->paginate(),
        ]);
    }
}
