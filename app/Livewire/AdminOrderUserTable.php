<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class AdminOrderUserTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // input جستجو
    public $searchInput = '';
    public $search = '';

    // فیلتر وضعیت
    public $statusFilter = '';
    public $userId;
    public function mount($userId = null)
    {
        // ✅ مقدار پیش‌فرض اگر پاس داده نشده باشه
        $this->$userId  = $userId ?? 0;
    }
    public function applySearch()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->searchInput = '';
        $this->search = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $orders = Order::query()
            ->where('user_id', $this->userId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('mobile', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin-order-table', compact('orders'));
    }
}
