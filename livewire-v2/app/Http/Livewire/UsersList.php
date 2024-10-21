<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    public ?string $search = null;
    public ?string $searchEmail = null;
    public int $limit = 5;
    public ?string $sortBy = null;
    public ?string $sortDir = 'asc';

    protected $listeners = [
        'user::updated' => '$refresh',
    ];

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'],
        'searchEmail' => ['except' => '', 'as' => 'eq'],
        'limit' => ['except' => '5', 'as' => 'l'],
        'sortBy' => ['except' => ''],
        'sortDir' => ['except' => 'asc'],
    ];

    public function updating(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDir = 'asc';
        }

        $this->sortBy = $column;
    }

    public function render(): View
    {
        return view('livewire.users-list', [
            'users' => User::query()
                ->when(
                    $this->search,
                    fn(Builder $query) => $query->where('name', 'like', '%'.$this->search.'%')
                )
                ->when(
                    $this->searchEmail,
                    fn(Builder $query) => $query->where('email', 'like', '%'.$this->searchEmail.'%')
                )
                ->when($this->sortBy, fn(Builder $query) => $query->orderBy($this->sortBy, $this->sortDir)
                )
                ->paginate($this->limit),
        ]);
    }
}
