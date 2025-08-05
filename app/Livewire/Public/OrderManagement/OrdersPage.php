<?php

namespace App\Livewire\Public\OrderManagement;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class OrdersPage extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('layouts.app')]

    public $status = 'all';
    public $search = '';
    public $statusCounts = [];

    protected $queryString = [
        'status' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->calculateStatusCounts();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function setFilter($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->status = 'all';
        $this->resetPage();
    }

    public function calculateStatusCounts()
    {
        if (Auth::check()) {
            $this->statusCounts = [
                'pending' => Auth::user()->orders()->where('status', 'pending')->count(),
                'processing' => Auth::user()->orders()->where('status', 'processing')->count(),
                'shipped' => Auth::user()->orders()->where('status', 'shipped')->count(),
                'delivered' => Auth::user()->orders()->where('status', 'delivered')->count(),
                'cancelled' => Auth::user()->orders()->where('status', 'cancelled')->count(),
            ];
        }
    }

    public function getStatusBadgeClass($status)
    {
        return match ($status) {
            'pending' => 'bg-yellow-100 text-yellow-600 border-yellow-200',
            'processing' => 'bg-blue-100 text-blue-600 border-blue-200',
            'paid' => 'bg-green-100 text-green-600 border-green-200',
            'shipped' => 'bg-purple-100 text-purple-600 border-purple-200',
            'delivered' => 'bg-green-100 text-green-600 border-green-200',
            'cancelled' => 'bg-red-100 text-red-600 border-red-200',
            default => 'bg-gray-100 text-gray-600 border-gray-200',
        };
    }

    public function getStatusLabel($status)
    {
        return match ($status) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'paid' => 'Paid',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => ucfirst($status),
        };
    }

    public function render()
    {
        if (!Auth::check()) {
            return view('livewire.public.order-management.orders-page', [
                'orders' => collect(),
            ]);
        }

        $query = Auth::user()->orders()->with(['items.product'])->orderBy('created_at', 'desc');

        if ($this->status !== 'all') {
            if ($this->status === 'processing') {
                $query->whereIn('status', ['processing', 'paid']);
            } elseif ($this->status === 'shipped') {
                $query->where('status', 'shipped');
            } elseif ($this->status === 'cancelled') {
                $query->whereIn('status', ['cancelled', 'failed']);
            } else {
                $query->where('status', $this->status);
            }
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('items.product', function ($productQuery) {
                        $productQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        return view('livewire.public.order-management.orders-page', [
            'orders' => $query->paginate(10),
        ]);
    }
}
