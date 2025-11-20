<?php

namespace App\Livewire\Forms;

use App\Models\Content;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ContentForm extends Form
{
    #[Rule(['required', 'string', 'min:30'])]
    public string $title;

    #[Rule(['required'])]
    public string $slug;

    #[Rule(['required', 'string', 'min:30'])]
    public ?string $description = null;

    #[Rule(['required'])]
    public string $body;

    #[Rule(['required'])]
    public string $status = 'DRAFT';

    #[Rule(['required'])]
    public string $type = 'MOVIE';

    public function setContent(Content $content): void
    {
        $this->fill([
            'title' => $content->title,
            'slug' => $content->slug,
            'description' => $content->description,
            'body' => $content->body,
            'status' => $content->status,
            'type' => $content->type,
        ]);
    }

    public function save(): bool
    {
        $this->validate();

        $data = $this->all();
        $data['code'] = str()->uuid();

        return (bool) Content::query()->create($data);
    }

    public function update(int $contentId): bool
    {
        $this->validate();

        $data = $this->all();

        $content = Content::query()->findOrFail($contentId);

        return $content->update($data);
    }
}
