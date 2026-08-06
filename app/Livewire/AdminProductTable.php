<?php

namespace App\Livewire;



use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProductTable extends Component
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
        $products = Product::query()

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



