<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $query = User::latest();

        if (request('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', 'string', 'max:50'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Utilisateur mis a jour');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);


        if (auth()->id() === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé');
    }
}