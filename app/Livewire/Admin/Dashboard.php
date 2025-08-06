<?php
namespace App\Livewire\Admin;

use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('layouts.admin')]

    public $kpi = [];
    public $totalRevenue = 0;

    public $ordersChartData = [
        'labels' => [],
        'data' => [],
    ];
    public $salesChartData = [
        'labels' => [],
        'data' => [],
    ];

    public function mount()
    {
        $this->loadKpi();
    }

    private function loadKpi()
    {
        $start = Carbon::today()->subDays(30);
        $this->kpi = [
            'totalUsers' => User::count(),
            'newUsers'   => User::where('created_at', '>=', $start)->count(),
            'totalOrders'=> Orders::count(),
            // 'revenue'    => Orders::where('status', 'paid')->sum('total'),
            'pending'    => Orders::where('status', 'pending')->count(),
        ];
         $this->totalRevenue = Orders::whereIn('status', ['paid', 'shipped', 'delivered'])
            ->sum('total');

    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
