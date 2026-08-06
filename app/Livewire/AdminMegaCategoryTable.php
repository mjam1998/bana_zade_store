<?php

namespace App\Livewire;

use App\Models\MegaCategory;
use Livewire\Component;
use Livewire\WithPagination;

class AdminMegaCategoryTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // input جستجو
    public $searchInput = '';
    public $search = '';

    public function applySearch()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function render()
    {
        $megaCategories = MegaCategory::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin-mega-category-table', compact('megaCategories'));
    }
}
