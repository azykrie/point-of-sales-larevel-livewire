<?php
namespace App\Livewire\Dashboard;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Supplier;
use Livewire\Attributes\Title;

#[Title("Dashboard")]
class Index extends Component
{
    public array $dailyIncomeChart = [];
    public array $bestSellerChart  = [];

    public function mount()
    {

        $sales = Sale::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        $this->dailyIncomeChart = [
            'type' => 'bar',
            'data' => [
                'labels'   => $sales->pluck('date')->map(fn($d) => date('d M', strtotime($d))),
                'datasets' => [
                    [
                        'label' => 'Daily',
                        'data'  => $sales->pluck('total'),
                    ],
                ],
            ],
        ];

        $bestSeller = \DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(sale_items.quantity) as total')
            ->groupBy('products.name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $this->bestSellerChart = [
            'type' => 'pie',
            'data' => [
                'labels'   => $bestSeller->pluck('name'),
                'datasets' => [
                    [
                        'label' => 'Best selling products',
                        'data'  => $bestSeller->pluck('total'),
                    ],
                ],
            ],
        ];
    }

    public function render()
    {
        $profit  = Sale::sum('total_amount');
        $order   = Sale::count();
        $user    = User::count();
        $product = Product::count();
        $category = Category::count();
        $supplier = Supplier::count();

        return view('livewire.dashboard.index', compact('profit', 'order', 'user', 'product', 'category', 'supplier'));
    }
}
