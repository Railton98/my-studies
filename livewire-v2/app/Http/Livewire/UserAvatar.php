<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserAvatar extends Component
{
    use WithFileUploads;

    public $avatar;

    public function save(): void
    {
        $ref = $this->avatar->store('public');

        $user = auth()->user();
        $user->avatar = $ref;
        $user->save();
    }

    public function download(): StreamedResponse|BinaryFileResponse
    {
//        return response()->download(storage_path('app'.DIRECTORY_SEPARATOR.auth()->user()->avatar));
        return Storage::download(auth()->user()->avatar);
    }

    public function render(): View
    {
        return view('livewire.user-avatar');
    }
}
