<div>
    <div class="p-6 space-y-6">
        <h1 class="text-2xl font-bold text-white">Admin Dashboard</h1>

        <!-- KPI Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <x-admin-card title="Total Users" :value="$kpi['totalUsers']" icon="users" />
            <x-admin-card title="New Users (30d)" :value="$kpi['newUsers']" icon="user-plus" />
            <x-admin-card title="Total Orders" :value="$kpi['totalOrders']" icon="shopping-cart" />
            <x-admin-card title="Revenue" :value="'$' . number_format($totalRevenue, 0)" icon="currency-dollar" />
        </div>
        <!-- Recent Orders Table -->
        <div class="rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold mb-3">Recent Orders</h2>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\Orders::with('user')->latest()->take(5)->get() as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td><span
                                    class="badge badge-sm {{ $order->status === 'paid' ? 'badge-success' : 'badge-secondary' }}">{{ $order->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
