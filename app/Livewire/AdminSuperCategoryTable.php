<?php

namespace App\Livewire;


use App\Models\SuperCategory;
use Livewire\Component;
use Livewire\WithPagination;

class AdminSuperCategoryTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // input جستجو
    public $searchInput = '';
    public $search = '';
    public $megaCategoryId;
    public function mount($megaCategoryId = null)
    {
        // ✅ مقدار پیش‌فرض اگر پاس داده نشده باشه
        $this->megaCategoryId  = $megaCategoryId ?? 0;
    }
    public function applySearch()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function render()
    {
        $superCategories = SuperCategory::query()
            ->where('mega_category_id', $this->megaCategoryId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin-super-category-table', compact('superCategories'));
    }
}

