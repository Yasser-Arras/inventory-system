<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // USERS

        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => Hash::make('00000000'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@test.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        // CATEGORIES
        $boissons = Category::create([
            'name' => 'Boissons',
            'description' => 'Sodas, jus et eau',
            'icon' => 'local_drink',
        ]);

        $eaux = Category::create([
            'name' => 'Eaux',
            'description' => 'Eaux minérales et gazeuses',
            'icon' => 'water_drop',
        ]);

        $snacks = Category::create([
            'name' => 'Snacks',
            'description' => 'Chips et biscuits',
            'icon' => 'restaurant',
        ]);

        $epicerie = Category::create([
            'name' => 'Epicerie',
            'description' => 'Produits alimentaires secs',
            'icon' => 'shopping_basket',
        ]);

        $frais = Category::create([
            'name' => 'Produits frais',
            'description' => 'Produits frais et laitiers',
            'icon' => 'egg_alt',
        ]);

        $menage = Category::create([
            'name' => 'Produits ménagers',
            'description' => 'Nettoyage et entretien',
            'icon' => 'cleaning_services',
        ]);

        $cosmetiques = Category::create([
            'name' => 'Cosmétiques',
            'description' => 'Soins personnels et beauté',
            'icon' => 'spa',
        ]);

        $electronique = Category::create([
            'name' => 'Électronique',
            'description' => 'Appareils et accessoires',
            'icon' => 'devices',
        ]);

        $divers = Category::create([
            'name' => 'Divers',
            'description' => 'Autres produits',
            'icon' => 'category',
        ]);

        // SUPPLIERS
        $coca = Supplier::create([
            'name' => 'Coca Cola Maroc',
            'contact_person' => 'Ahmed El Mansouri',
            'phone' => '0612345678',
            'city' => 'Casablanca',
            'address' => 'Zone Industrielle Ain Sebaa',
            'status' => 'active',
        ]);

        $nestle = Supplier::create([
            'name' => 'Nestle Distribution',
            'contact_person' => 'Sara Bennani',
            'phone' => '0623456789',
            'city' => 'Rabat',
            'address' => 'Hay Riad, Avenue Annakhil',
            'status' => 'inactive',
        ]);
        $local = Supplier::create([
            'name' => 'Fournisseur Local',
            'contact_person' => 'Ahmed El Youssfi',
            'phone' => '0600000000',
            'city' => 'Casablanca',
            'address' => 'Local de stockage, Route de Nouaceur',
            'status' => 'active',
        ]);
        // PRODUCTS
        Product::create([
            'name' => 'Coca Cola 1L',
            'price' => 12,
            'quantity_stock' => 50,
            'category_id' => $boissons->id,
            'supplier_id' => $coca->id,
        ]);

        Product::create([
            'name' => 'Fanta Orange 1L',
            'price' => 12,
            'quantity_stock' => 45,
            'category_id' => $boissons->id,
            'supplier_id' => $coca->id,
        ]);

        Product::create([
            'name' => 'Eau Sidi Ali 1.5L',
            'price' => 6,
            'quantity_stock' => 120,
            'category_id' => $eaux->id,
            'supplier_id' => $local->id,
        ]);

        Product::create([
            'name' => 'Chips Lays',
            'price' => 8,
            'quantity_stock' => 80,
            'category_id' => $snacks->id,
            'supplier_id' => $nestle->id,
        ]);

        Product::create([
            'name' => 'Biscuit Oreo',
            'price' => 10,
            'quantity_stock' => 60,
            'category_id' => $snacks->id,
            'supplier_id' => $nestle->id,
        ]);

        Product::create([
            'name' => 'Riz 1kg',
            'price' => 18,
            'quantity_stock' => 100,
            'category_id' => $epicerie->id,
            'supplier_id' => $local->id,
        ]);

        Product::create([
            'name' => 'Sucre 1kg',
            'price' => 10,
            'quantity_stock' => 90,
            'category_id' => $epicerie->id,
            'supplier_id' => $local->id,
        ]);

        Product::create([
            'name' => 'Lait Candia 1L',
            'price' => 9,
            'quantity_stock' => 70,
            'category_id' => $frais->id,
            'supplier_id' => $nestle->id,
        ]);

        Product::create([
            'name' => 'Yaourt Danone x4',
            'price' => 14,
            'quantity_stock' => 55,
            'category_id' => $frais->id,
            'supplier_id' => $nestle->id,
        ]);

        Product::create([
            'name' => 'Savon liquide',
            'price' => 25,
            'quantity_stock' => 40,
            'category_id' => $menage->id,
            'supplier_id' => $local->id,
        ]);

        Product::create([
            'name' => 'Javel 1L',
            'price' => 15,
            'quantity_stock' => 35,
            'category_id' => $menage->id,
            'supplier_id' => $local->id,
        ]);

        Product::create([
            'name' => 'Shampoing Head & Shoulders',
            'price' => 28,
            'quantity_stock' => 60,
            'category_id' => $cosmetiques->id,
            'supplier_id' => $local->id,
        ]);

        Product::create([
            'name' => 'Parfum homme 50ml',
            'price' => 120,
            'quantity_stock' => 20,
            'category_id' => $cosmetiques->id,
            'supplier_id' => $local->id,
        ]);

        Product::create([
            'name' => 'Chargeur USB',
            'price' => 35,
            'quantity_stock' => 30,
            'category_id' => $electronique->id,
            'supplier_id' => $local->id,
        ]);

        Product::create([
            'name' => 'Écouteurs Bluetooth',
            'price' => 80,
            'quantity_stock' => 25,
            'category_id' => $electronique->id,
            'supplier_id' => $local->id,
        ]);
    }
}