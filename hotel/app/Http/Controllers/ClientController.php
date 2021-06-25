<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {
       return Inertia::render('Clients/Index', [
            'clients' => Client::all()
        ]);
    }

    public function update(Request $request, Client $client) {
        $validatet = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|numeric'
        ]);

        $client->update($validatet);

        return redirect()->back()->with('success', 'Zapisano');
    }

    public function delete(Client $client) {
        $client->delete();

        return redirect()->back()->with('success', 'Zapisano');
    }
}
