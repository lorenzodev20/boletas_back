<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = "reservas";
    protected $fillable = [
        'id','comprador_id', 'boleta_id','nombre_evento','cantidad'
    ];
}
