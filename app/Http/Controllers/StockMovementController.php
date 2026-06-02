<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('product')
            ->latest()
            ->get();

        $products = Product::orderBy('name')->get();

        $totalProducts = Product::count();

        $totalUnits = Product::sum('quantity_stock');

        $lowStockProducts = Product::where('quantity_stock', '<=', 10)->get();

        $totalValue = Product::selectRaw('SUM(quantity_stock * price) as value')
            ->value('value');

        return view('stock-movements.index', compact(
            'movements',
            'products',
            'totalProducts',
            'totalUnits',
            'lowStockProducts',
            'totalValue'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($data['type'] === 'IN') {
            $product->quantity_stock += $data['quantity'];
        } else {
            $product->quantity_stock -= $data['quantity'];
        }

        $product->save();

        StockMovement::create($data);

        return back()->with('success', 'Mouvement enregistré');
    }


    public function revert($id)
    {
        $movement = StockMovement::findOrFail($id);
        $product = $movement->product;

        if ($movement->type === 'IN') {
            $product->quantity_stock -= $movement->quantity;
        } else {
            $product->quantity_stock += $movement->quantity;
        }

        $product->save();

        $movement->delete();

        return back()->with('success', 'Mouvement annulé');
    }
    public function destroy($id)
    {
        $movement = StockMovement::findOrFail($id);

        $movement->delete();

        return back()->with('success', 'Mouvement supprimé');
    }
}