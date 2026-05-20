<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function catalogue(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12);

        return view('catalogue.index', [
            'products' => $products,
            'categories' => Category::all(),
        ]);
    }
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        $query = Product::with(['category', 'supplier']);

        $query->when(
            $request->name,
            fn($q, $name) =>
            $q->where('name', 'like', "%{$name}%")
        );

        $query->when(
            $request->filled('category_id'),
            fn($q) =>
            $q->where('category_id', $request->category_id)
        );

        $query->when(
            $request->filled('supplier_id'),
            fn($q) =>
            $q->where('supplier_id', $request->supplier_id)
        );

        $products = $query->latest()->paginate(10)->withQueryString();

        $totalProducts = Product::count();

        $mostStocked = Product::orderByDesc('quantity_stock')->first();

        $leastStocked = Product::orderBy('quantity_stock')->first();

        $lastWeekCount = Product::where('created_at', '>=', now()->subDays(7))->count();

        $previousWeekCount = Product::whereBetween('created_at', [
            now()->subDays(14),
            now()->subDays(7)
        ])->count();

        $lastWeekPercent = $previousWeekCount > 0
            ? round((($lastWeekCount - $previousWeekCount) / $previousWeekCount) * 100, 1)
            : 0;

        return view('products.index', compact(
            'products',
            'categories',
            'suppliers',
            'totalProducts',
            'mostStocked',
            'leastStocked',
            'lastWeekCount',
            'lastWeekPercent'
        ))->with([
                    'name' => $request->name
                ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('products.index', ['open' => 'create']);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $this->validated($request);

        $exists = Product::where('name', $data['name'])
            ->where('price', $data['price'])
            ->where('category_id', $data['category_id'])
            ->where('supplier_id', $data['supplier_id'])
            ->where('quantity_stock', $data['quantity_stock'])
            ->latest()
            ->first();

        if ($exists && $exists->created_at->diffInSeconds(now()) < 3) {
            return $this->respond($request, 'Produit déjà ajouté.');
        }

        Product::create($data);

        return $this->respond($request, 'Produit ajouté avec succès.');
    }

    public function edit(Product $product): RedirectResponse
    {
        return redirect()->route('products.index', ['edit' => $product->id]);
    }

    public function update(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $product->update($this->validated($request));

        return $this->respond($request, 'Produit mis à jour avec succès.');
    }

    public function destroy(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $product->delete();

        return $this->respond($request, 'Produit supprimé avec succès.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity_stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'description' => 'nullable|string',
        ]);
    }

    private function respond(Request $request, string $message): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', $message);
    }
}