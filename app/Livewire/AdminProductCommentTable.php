<?php

namespace App\Livewire;



use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProductCommentTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // input جستجو
    public $searchInput = '';
    public $search = '';
    public $productId;
    public function mount($productId = null)
    {
        // ✅ مقدار پیش‌فرض اگر پاس داده نشده باشه
        $this->productId  = $productId ?? 0;
    }
    public function applySearch()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function render()
    {
        $comments = Comment::query()
            ->where('product_id', $this->productId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin-product-comment-table', compact('comments'));
    }
}




