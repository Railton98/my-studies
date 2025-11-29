<?php

namespace App\Livewire\Media;

use App\Jobs\VideoEncodingJob;
use App\Models\Content;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class VideoUpload extends Component
{
    use WithFileUploads;

    public array $videos;

    public Content $content;

    public function storeVideos()
    {
        $this->validate();

        /** @var TemporaryUploadedFile $video */
        foreach ($this->videos as $video) {
            $createdVideo = $this->content->videos()->create([
                'name' => $video->getClientOriginalName(),
                'video' => $video->store('', 'videos'),
                'code' => str()->uuid(),
            ]);

            dispatch(new VideoEncodingJob($createdVideo));
        }
    }

    public function rules(): array
    {
        return [
            'videos.*' => [
                'required',
                'file',
                'mimetypes:video/mp4,video/mpeg,video/x-matroska,application/octet-stream',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.media.video-upload');
    }
}
