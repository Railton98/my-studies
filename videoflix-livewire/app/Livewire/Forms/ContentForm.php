<?php

namespace App\Livewire\Forms;

use App\Models\Content;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ContentForm extends Form
{
    #[Rule(['required', 'string', 'min:10'])]
    public string $title;

    #[Rule(['required'])]
    public string $slug;

    #[Rule(['nullable', 'string', 'min:30'])]
    public ?string $description = null;

    #[Rule(['required'])]
    public string $body;

    #[Rule(['nullable', 'image'])]
    public $cover;

    #[Rule(['required'])]
    public string $status = 'DRAFT';

    #[Rule(['required'])]
    public string $type = 'MOVIE';

    public ?string $coverReal = null;

    public function setContent(Content $content): void
    {
        $this->fill([
            'title' => $content->title,
            'slug' => $content->slug,
            'description' => $content->description,
            'body' => $content->body,
            'coverReal' => $content->cover,
            'status' => $content->status,
            'type' => $content->type,
        ]);
    }

    public function save(): bool
    {
        $this->validate();

        $data = $this->all();
        $data['code'] = str()->uuid();
        $data['cover'] = $data['cover']?->store('contents', 'public');

        return (bool) Content::query()->create($data);
    }

    public function update(int $contentId): bool
    {
        $this->validate();

        $data = $this->all();
        $content = Content::query()->findOrFail($contentId);

        if ($data['cover']) {
            $disk = Storage::disk('public');

            if ($content->cover && $disk->exists($content->cover)) {
                $disk->delete($content->cover);
            }

            $data['cover'] = $data['cover']->store('contents', 'public');
        }

        return $content->update($data);
    }
}
