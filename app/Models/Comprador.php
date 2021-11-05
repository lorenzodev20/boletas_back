<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprador extends Model
{
    use HasFactory;

    protected $table = "comprador";
    protected $fillable = [
        'id','nombre', 'apellido', 'identificacion', 'telefono'
    ];
}
