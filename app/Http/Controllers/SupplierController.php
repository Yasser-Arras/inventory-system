<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
   public function index(Request $request)
{
    $query = Supplier::query();

   
    if ($request->filled('search')) {

        $search = $request->search;
        $filter = $request->filter ?? 'name';

        $query->where(function ($q) use ($search, $filter) {

            if ($filter === 'name') {
                $q->where('name', 'like', "%$search%");
            }

            elseif ($filter === 'contact_person') {
                $q->where('contact_person', 'like', "%$search%");
            }

            elseif ($filter === 'phone') {
                $q->where('phone', 'like', "%$search%");
            }

            elseif ($filter === 'city') {
                $q->where('city', 'like', "%$search%");
            }
        });
    }

    $suppliers = $query->latest()->get();

    $totalSuppliers = Supplier::count();

    $activeSuppliers = Supplier::where('status', 'active')->count();

    $citiesCount = Supplier::distinct('city')->count('city');

    $totalPurchases = Product::sum('price');

    $cities = [
        'Casablanca','Rabat','Marrakech','Fes','Tangier','Agadir',
        'Meknes','Oujda','Kenitra','Tetouan','Safi','El Jadida',
        'Beni Mellal','Nador','Taza','Laayoune','Dakhla',
    ];

    return view('suppliers.index', compact(
        'suppliers',
        'totalSuppliers',
        'activeSuppliers',
        'citiesCount',
        'totalPurchases',
        'cities'
    ));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Supplier::create($data);

        return back()->with('success', 'Fournisseur ajouté');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $supplier->update($data);

        return back()->with('success', 'Fournisseur modifié');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return back()->with('success', 'Fournisseur supprimé');
    }
}