<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class UsersList extends Component
{
    public ?string $search = null;

    protected $listeners = [
        'user::updated' => '$refresh',
    ];

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'],
    ];

    public function render(): View
    {
        return view('livewire.users-list', [
            'users' => User::query()
                ->when(
                    $this->search,
                    fn(Builder $query) => $query->where('name', 'like', '%'.$this->search.'%')
                )
                ->get(),
        ]);
    }
}
