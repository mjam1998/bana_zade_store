<?php

namespace App\Livewire;


use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoryTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // input جستجو
    public $searchInput = '';
    public $search = '';
    public $superCategoryId;
    public function mount($superCategoryId = null)
    {
        // ✅ مقدار پیش‌فرض اگر پاس داده نشده باشه
        $this->superCategoryId  = $superCategoryId ?? 0;
    }
    public function applySearch()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::query()
            ->where('super_category_id', $this->superCategoryId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                     ->orWhere('slug', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin-category-table', compact('categories'));
    }
}


