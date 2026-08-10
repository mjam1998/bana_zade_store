<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class AdminTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // input جستجو
    public $searchInput = '';
    public $search = '';
    public $selectedRole = '';

    public function applySearch()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function render()
    {
        $roles = Role::all();

        $users = User::query()
            ->with('roles')
            ->when($this->search, fn($q) =>
            $q->where(fn($q) =>
            $q->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('mobile', 'like', '%'.$this->search.'%')
             )
            )
            ->when($this->selectedRole, fn($q) =>
            $q->whereHas('roles', fn($q) =>
            $q->where('name', $this->selectedRole)
             )
            )
            ->latest()
            ->paginate(10);

        return view('livewire.admin-table', compact('users', 'roles'));
    }

}


