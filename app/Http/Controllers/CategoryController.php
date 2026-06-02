<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
 
 private array $icons = [
    // Drinks
    'local_drink',
    'water_drop',
    'coffee',
    'emoji_food_beverage',

    // Food / grocery
    'shopping_basket',
    'restaurant',
    'rice_bowl',
    'egg_alt',
    'bakery_dining',
    'lunch_dining',
    'set_meal',
    'inventory_2',

    // Snacks / sweets
    'cookie',
    'icecream',
    'cake',

    // Cleaning / household
    'cleaning_services',
    'local_laundry_service',
    'soap',
    'home',
    'sprinkler',

    // Health / beauty
    'spa',
    'medication',
    'face_retouching_natural',
    'air',

    // Electronics
    'devices',
    'smartphone',
    'computer',
    'cable',
    'memory',

    // Clothing / retail
    'checkroom',
    'footprint',
    'dry_cleaning',

    // Tools / misc
    'construction',
    'handyman',
    'hardware',
    'category',
    'sell',
    'shopping_cart',
];
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        switch ($request->order) {
            case 'products':
                $query->orderBy('products_count', 'desc');
                break;

            case 'created_at':
                $query->orderBy('created_at', 'desc');
                break;

            default:
                $query->orderBy('name', 'asc');
                break;
        }

        $categories = $query->paginate(10)->withQueryString();

        return view('categories.index', [
            'categories' => $categories,
            'icons' => $this->icons,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|in:' . implode(',', $this->icons),
        ]);

        Category::create($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie ajoutée');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|in:' . implode(',', $this->icons),
        ]);

        $category->update($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie mise à jour');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie supprimée');
    }
}