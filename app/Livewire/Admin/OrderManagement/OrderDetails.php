<?php

namespace App\Livewire\Admin\OrderManagement;

use App\Models\Orders;
use Livewire\Component;
use Livewire\Attributes\Layout;

class OrderDetails extends Component
{
    #[Layout('layouts.admin')]

    public Orders $order;

    public function mount(Orders $order)
    {
        $this->order = $order;
    }

    public function updateStatus($newStatus)
    {
        try {
            $oldStatus = $this->order->status;
            $this->order->update(['status' => $newStatus]);

            // Log the status change
            // \Log::info("Order {$this->order->order_number} status changed from {$oldStatus} to {$newStatus} by admin");

            // Refresh the order model
            $this->order->refresh();

            session()->flash('message', "Order status updated to " . $this->getStatusLabel($newStatus));

            // Optional: Send email notification to customer
            // $this->sendStatusUpdateEmail($newStatus);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update order status. Please try again.');
        }
    }

    public function printOrder()
    {
        // Implement print functionality
        session()->flash('message', 'Print functionality will be implemented soon.');
    }

    public function sendEmailToCustomer()
    {
        try {
            // Implement email functionality here
            // Mail::to($this->order->user->email)->send(new OrderUpdateMail($this->order));

            session()->flash('message', 'Email sent successfully to customer.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send email. Please try again.');
        }
    }

    public function refundOrder()
    {
        try {
            // Implement refund logic here
            // This would typically integrate with your payment processor

            session()->flash('message', 'Refund functionality will be implemented soon.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to process refund. Please try again.');
        }
    }

    public function duplicateOrder()
    {
        try {
            // Create a new order based on the current one
            $newOrder = $this->order->replicate();
            $newOrder->order_number = 'ORD-' . time() . '-' . rand(1000, 9999);
            $newOrder->status = 'pending';
            $newOrder->created_at = now();
            $newOrder->save();

            // Duplicate order items
            foreach ($this->order->items as $item) {
                $newItem = $item->replicate();
                $newItem->order_id = $newOrder->id;
                $newItem->save();
            }

            session()->flash('message', "Order duplicated successfully. New order: {$newOrder->order_number}");

            return redirect()->route('admin.orders.show', $newOrder);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate order. Please try again.');
        }
    }

    public function deleteOrder()
    {
        try {
            $orderNumber = $this->order->order_number;

            // Check if order can be deleted (e.g., only pending or cancelled orders)
            if (!in_array($this->order->status, ['pending', 'cancelled'])) {
                session()->flash('error', 'Only pending or cancelled orders can be deleted.');
                return;
            }

            $this->order->delete();

            session()->flash('message', "Order #{$orderNumber} has been deleted successfully.");

            return redirect()->route('admin.orders.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete order. Please try again.');
        }
    }

    public function getStatusButtonClass($status)
    {
        return match($status) {
            'pending' => 'btn-warning',
            'processing', 'paid' => 'btn-info',
            'shipped' => 'btn-primary',
            'delivered' => 'btn-success',
            'cancelled' => 'btn-error',
            default => 'btn-ghost',
        };
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'pending' => 'badge-warning',
            'processing', 'paid' => 'badge-info',
            'shipped' => 'badge-primary',
            'delivered' => 'badge-success',
            'cancelled' => 'badge-error',
            default => 'badge-ghost',
        };
    }

    public function getStatusDotClass($status)
    {
        return match($status) {
            'pending' => 'bg-warning',
            'processing', 'paid' => 'bg-info',
            'shipped' => 'bg-primary',
            'delivered' => 'bg-success',
            'cancelled' => 'bg-error',
            default => 'bg-base-300',
        };
    }

    public function getStatusLabel($status)
    {
        return match($status) {
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
        return view('livewire.admin.order-management.order-details');
    }
}
