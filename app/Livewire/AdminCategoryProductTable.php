<?php

namespace App\Livewire;



use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoryProductTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // input جستجو
    public $searchInput = '';
    public $search = '';
    public $categoryId;
    public function mount($categoryId = null)
    {
        // ✅ مقدار پیش‌فرض اگر پاس داده نشده باشه
        $this->categoryId  = $categoryId ?? 0;
    }
    public function applySearch()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::query()
            ->where('category_id', $this->categoryId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%')
                         ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin-product-table', compact('products'));
    }
}



