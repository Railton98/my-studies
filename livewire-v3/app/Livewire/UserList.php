<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->select(['id', 'name', 'email'])
            ->paginate();
    }

    public function render(): View
    {
        return view('livewire.user-list');
    }
}
