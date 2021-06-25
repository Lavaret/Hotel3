<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'check_in',
        'check_out',
        'room_id',
        'client_id'
    ];

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
