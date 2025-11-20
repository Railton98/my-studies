<?php

namespace App\Livewire\Media;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class VideoUpload extends Component
{
    use WithFileUploads;

    public $videos;

    public function storeVideos()
    {
        dd($this->videos);
    }

    public function render(): View
    {
        return view('livewire.media.video-upload');
    }
}
