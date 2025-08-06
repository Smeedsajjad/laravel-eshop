<?php

namespace App\Livewire\Admin\OrderManagement;

use App\Models\Orders;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

class OrdersDashboard extends Component
{
    use WithPagination;

    #[Layout('layouts.admin')]

    public $search = '';
    public $status = 'all';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $statusCounts = [];
    public $todayOrders = 0;
    public $totalRevenue = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        $this->calculateStats();
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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->status = 'all';
        $this->resetPage();
    }

    public function updateOrderStatus($orderId, $newStatus)
    {
        try {
            $order = Orders::findOrFail($orderId);
            $oldStatus = $order->status;

            $order->update(['status' => $newStatus]);

            $this->calculateStats();

            session()->flash('message', "Order #{$order->order_number} status updated to " . $this->getStatusLabel($newStatus));

            // Optional: Send email notification to customer
            // $this->sendStatusUpdateEmail($order, $newStatus);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update order status. Please try again.');
        }
    }

    public function deleteOrder($orderId)
    {
        try {
            $order = Orders::findOrFail($orderId);
            $orderNumber = $order->order_number;

            $order->delete();

            $this->calculateStats();
            session()->flash('message', "Order #{$orderNumber} has been deleted.");
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete order. Please try again.');
        }
    }

    public function printOrder($orderId)
    {
        session()->flash('message', 'Print functionality will be implemented soon.');
    }

    public function sendEmail($orderId)
    {
        session()->flash('message', 'Email functionality will be implemented soon.');
    }

    public function exportOrders($format)
    {
        session()->flash('message', "Export as {$format} functionality will be implemented soon.");
    }

    private function calculateStats()
    {
        $this->todayOrders = Orders::whereDate('created_at', Carbon::today())->count();

        $this->totalRevenue = Orders::whereIn('status', ['paid', 'shipped', 'delivered'])
            ->sum('total');

        $this->statusCounts = [
            'all' => Orders::count(),
            'pending' => Orders::where('status', 'pending')->count(),
            'processing' => Orders::whereIn('status', ['paid', 'processing'])->count(),
            'shipped' => Orders::where('status', 'shipped')->count(),
            'delivered' => Orders::where('status', 'delivered')->count(),
            'cancelled' => Orders::where('status', 'cancelled')->count(),
        ];
    }

    public function getStatusButtonClass($status)
    {
        return match ($status) {
            'pending' => 'btn-warning',
            'processing', 'paid' => 'btn-info',
            'shipped' => 'btn-primary',
            'delivered' => 'btn-success',
            'cancelled' => 'btn-error',
            default => 'btn-ghost',
        };
    }

    public function getStatusDotClass($status)
    {
        return match ($status) {
            'pending' => 'bg-warning',
            'processing', 'paid' => 'bg-info',
            'shipped' => 'bg-primary',
            'delivered' => 'bg-success',
            'cancelled' => 'bg-error',
            default => 'bg-gray-400',
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
        $query = Orders::with(['user', 'items.product'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('order_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status !== 'all', function ($q) {
                if ($this->status === 'processing') {
                    $q->whereIn('status', ['processing', 'paid']);
                } elseif ($this->status === 'cancelled') {
                    $q->where('status', 'cancelled');
                } else {
                    $q->where('status', $this->status);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.admin.order-management.orders-dashboard', [
            'orders' => $query->paginate(15),
        ]);
    }
}
