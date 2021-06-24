<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ReservationController extends Controller
{
    public function index() {
        return Inertia::render('Reservations', [
            'reservations' => Reservation::all()
        ]);
    }
    public function zrobRezerwacje(Request $request) {

        $validated = $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'room_id' => 'exists:rooms,id',
            'client_id' => 'exclude_if:client,new|exists:clients,id',
            'clientDaata.firstname' => 'exclude_if:client,choose|string|max:255',
            'clientData.lastname' => 'exclude_if:client,choose|string|max:255',
            'clientData.phone' => 'exclude_if:client,choose|string|max:255',
        ]);

        $reservation = $request->only('check_in', 'check_out', 'room_id', 'client_id');
        $reservation = new Reservation($reservation);

        $clientData = $request->get('clientData');

        if(!$clientData->isEmpty()) {
            $client = Client::create($clientData);
            $reservation->client_id = $client->id;
        }
        $reservation->save();

        return Redirect::back()->with(['success' => 'dodano rezerwację']);
    }
}
