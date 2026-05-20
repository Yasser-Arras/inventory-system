<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        return view('sales.index', [
            'products' => Product::with('category')->orderBy('name')->get(),
            'sales' => Sale::with('user')->latest()->get()
        ]);
    }
    public function show(Sale $sale)
    {
        $sale->load(['user', 'items.product']);

        return view('sales.show', compact('sale'));
    }
    public function store(Request $request)
    {
        $cart = json_decode($request->cart, true);

        if (!$cart || count($cart) === 0) {
            return back()->with('error', 'Panier vide');
        }

        DB::beginTransaction();

        try {

            $total = 0;


            $sale = Sale::create([
                'user_id' => Auth::id(),
                'total_price' => 0,
            ]);

            foreach ($cart as $item) {

                $product = Product::findOrFail($item['id']);

                //  stock check
                if ($product->quantity_stock < $item['quantity']) {
                    throw new \Exception("Stock insuffisant pour {$product->name}");
                }

                //  compute total
                $lineTotal = $product->price * $item['quantity'];
                $total += $lineTotal;

                //  create sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity_sold' => $item['quantity'],
                ]);

                //  update stock
                $product->decrement('quantity_stock', $item['quantity']);
            }

            // update final total once
            $sale->update([
                'total_price' => $total,
            ]);

            DB::commit();

            return redirect()
                ->route('sales.index')
                ->with('success', 'Vente créée avec succès');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {

            foreach ($sale->items as $item) {

                $product = Product::find($item->product_id);

                if ($product) {
                    $product->quantity_stock += $item->quantity_sold;
                    $product->save();
                }
            }

            $sale->items()->delete();
            $sale->delete();
        });

        return back();
    }
}