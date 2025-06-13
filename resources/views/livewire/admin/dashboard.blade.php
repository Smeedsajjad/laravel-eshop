<div>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div>
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

                </div>
            </div>

        </div>

        <div class="mt-10 card bg-base-100 shadow-md overflow-x-auto">
            <div class="card-body">
                <h3 class="card-title">Recent Orders</h3>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-5523</td>
                                <td>John Smith</td>
                                <td>May 10, 2025</td>
                                <td>$125.99</td>
                                <td><span class="badge badge-success">Completed</span></td>
                                <td><a href="#" class="btn btn-ghost btn-xs">View</a></td>
                            </tr>
                            <tr>
                                <td>#ORD-5522</td>
                                <td>Sarah Johnson</td>
                                <td>May 9, 2025</td>
                                <td>$89.50</td>
                                <td><span class="badge badge-warning">Processing</span></td>
                                <td><a href="#" class="btn btn-ghost btn-xs">View</a></td>
                            </tr>
                            <tr>
                                <td>#ORD-5521</td>
                                <td>Michael Brown</td>
                                <td>May 9, 2025</td>
                                <td>$432.25</td>
                                <td><span class="badge badge-success">Completed</span></td>
                                <td><a href="#" class="btn btn-ghost btn-xs">View</a></td>
                            </tr>
                            <tr>
                                <td>#ORD-5520</td>
                                <td>Emily Davis</td>
                                <td>May 8, 2025</td>
                                <td>$76.00</td>
                                <td><span class="badge badge-error">Cancelled</span></td>
                                <td><a href="#" class="btn btn-ghost btn-xs">View</a></td>
                            </tr>
                            <tr>
                                <td>#ORD-5519</td>
                                <td>Robert Wilson</td>
                                <td>May 8, 2025</td>
                                <td>$214.75</td>
                                <td><span class="badge badge-info">Shipped</span></td>
                                <td><a href="#" class="btn btn-ghost btn-xs">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-actions justify-end mt-4">
                    <a href="#" class="btn btn-primary btn-sm">
                        View All Orders
                    </a>
                </div>
            </div>
        </div>
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        </div>
        <hr class="mt-10">

    </div>
