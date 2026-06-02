<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{

    public function index()
    {
        $totalProducts = Product::count();

        $totalSales = Sale::sum('total_price');

        $stockValue = Product::selectRaw('SUM(price * quantity_stock) as total')
            ->value('total') ?? 0;

        $lowStockCount = Product::where('quantity_stock', '<=', 10)->count();

        $lowStockProducts = Product::where('quantity_stock', '<=', 10)
            ->orderBy('quantity_stock')
            ->take(6)
            ->get();

        $latestProducts = Product::with('category')
            ->latest()
            ->take(4)
            ->get();

        $bestProducts = $this->bestSellingProducts();

        $recentActivity = $this->recentActivityFeed();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalSales',
            'stockValue',
            'lowStockProducts',
            'lowStockCount',
            'latestProducts',
            'recentActivity',
            'bestProducts',
        ));
    }

    private function bestSellingProducts(): Collection
    {
        return SaleItem::query()
            ->selectRaw('product_id, SUM(quantity_sold) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(4)
            ->get()
            ->filter(fn ($row) => $row->product !== null);
    }

    private function recentActivityFeed(): Collection
    {
        $items = collect();

        Sale::query()
            ->latest()
            ->with('user')
            ->take(5)
            ->get()
            ->each(function (Sale $sale) use ($items) {
                $items->push([
                    'icon' => 'check',
                    'color' => 'primary',
                    'title' => 'Vente réussie',
                    'label' => 'Commande #' . $sale->id,
                    'detail' => $sale->created_at?->diffForHumans() ?? 'Récemment',
                    'extra' => '+' . number_format($sale->total_price, 0, ',', ' ') . ' MAD',
                    'extra_class' => 'text-primary font-medium',
                    'at' => $sale->created_at ?? now(),
                ]);
            });

        StockMovement::query()
            ->with('product')
            ->latest()
            ->take(5)
            ->get()
            ->each(function (StockMovement $movement) use ($items) {
                $items->push([
                    'icon' => 'inventory',
                    'color' => 'secondary',
                    'title' => 'Stock mis à jour',
                    'label' => $movement->product?->name ?? 'Produit',
                    'detail' => ($movement->created_at?->diffForHumans() ?? 'Récemment')
                        . ' • ' . ($movement->type === 'IN' ? '+' : '-') . $movement->quantity . ' unités',
                    'extra' => null,
                    'extra_class' => null,
                    'at' => $movement->created_at ?? now(),
                ]);
            });

        Product::query()
            ->with('category')
            ->latest()
            ->take(3)
            ->get()
            ->each(function (Product $product) use ($items) {
                $items->push([
                    'icon' => 'add',
                    'color' => 'tertiary',
                    'title' => 'Nouveau produit',
                    'label' => $product->name,
                    'detail' => ($product->created_at?->diffForHumans() ?? 'Récemment')
                        . ' • Cat: ' . ($product->category?->name ?? '—'),
                    'extra' => null,
                    'extra_class' => null,
                    'at' => $product->created_at ?? now(),
                ]);
            });

        return $items
            ->sortByDesc('at')
            ->take(6)
            ->values();
    }
}