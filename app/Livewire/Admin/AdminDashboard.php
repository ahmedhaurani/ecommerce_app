<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Carbon\Carbon;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $todayOrders;
    public $thisMonthOrders;
    public $lastMonthOrders;
    public $thisYearOrders;
    public $totalOrders;
    public $totalProducts;
    public $totalBrands;
    public $totalCategories;
    public $monthlyOrdersData;


    public $todayRevenue;
    public $thisMonthRevenue;
    public $thisYearRevenue;
    public $totalRevenue;

    public function mount()
    {

        $now = Carbon::now();
        // Fetch today's orders
        $this->todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // Fetch this month's orders
        $this->thisMonthOrders = Order::whereMonth('created_at', Carbon::now()->month)->count();

        // Fetch last month's orders
        $this->lastMonthOrders = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

        // Fetch total orders
        $this->totalOrders = Order::count();
        $this->thisYearOrders = Order::whereYear('created_at', $now->year)->count();
        // Fetch total products, brands, and categories
        $this->totalProducts = Product::count();
        $this->totalBrands = Brand::count();
        $this->totalCategories = Category::count();

        // Fetch monthly orders data for chart
        $this->monthlyOrdersData = $this->getMonthlyOrdersData();



        $this->todayRevenue = Order::whereDate('created_at', $now->toDateString())->sum('total_amount');
        $this->thisMonthRevenue = Order::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->sum('total_amount');
        $this->thisYearRevenue = Order::whereYear('created_at', $now->year)->sum('total_amount');
        $this->totalRevenue = Order::sum('total_amount');
    }

    public function getMonthlyOrdersData()
    {
        $orders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = $orders->where('month', $i)->first()->total ?? 0;
        }

        return array_values($monthlyData);
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard', [
            'monthlyOrdersData' => $this->monthlyOrdersData,
        ]);
    }
}
