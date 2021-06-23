<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Client;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function wyszukajPokoj() {
        return Inertia::render('Search');
    }


    public function pokazRezultat(Request $request) {
        $validated = $request->validate([
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'beds' => 'required|max:5',
            'has_bathroom' => 'nullable',
            'has_balcony' => 'nullable',
            'has_wifi' => 'nullable'
        ]);

        $rooms = Room::leftJoin('reservations', 'room_id', '=', 'rooms.id')
            ->where('rooms.beds', '<=', $validated['beds'])
            ->where(function ($query) use ($validated) {
                $query->whereNotBetween('reservations.check_in', [$validated['check_in_date'], $validated['check_out_date']])
                    ->whereNotBetween('reservations.check_out', [$validated['check_in_date'], $validated['check_out_date']])
                    ->orWhereNull('check_in')
                    ->orWhereNull('check_out');
            })
            ->when(array_key_exists('has_bathroom', $validated), function ($query) {
                return $query->where('has_bathroom', 1);
            })
            ->when(array_key_exists('has_balcony', $validated), function ($query) {
                return $query->where('has_balcony', 1);
            })
            ->when(array_key_exists('has_wifi', $validated), function ($query) {
                return $query->where('has_wifi', 1);
            })->get();

        $dates['check_in'] = $validated['check_in_date'];
        $dates['check_out'] = $validated['check_out_date'];

        $clients = Client::all();

        return Inertia::render('Rooms', compact('rooms', 'dates', 'clients'));
    }
}
