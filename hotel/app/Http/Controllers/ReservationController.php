<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function zrobRezerwacje(Request $request) {

        $validated = $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'room_id' => 'integer|exists:rooms'
        ]);

        return 'works';
    }
}
