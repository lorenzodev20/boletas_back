<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Comprador;
use App\Models\Boleta;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    /**
     * Muestra la lista de reservas de boletas realizadas
     *
     */
    public function index()
    {
        $reservas = DB::table('reservas as r')
                    ->join('comprador as c', 'r.comprador_id','=','c.id')
                    ->select('r.*','c.nombre','c.apellido')
                    ->get()->toArray();
        // $reservas = Reserva::all();
        return $reservas;
    }

    /**
     * Devuelve al cliente un listado en json de los compradores y las boletas registradas en el sistema
     */
    public function listaCompradoresYBoletas()
    {
        $compradores = Comprador::all();

        $boletas = Boleta::where('disponible','>',0)->get();

        $datos = array('compradores'=>$compradores, 'boletas' => $boletas);

        return response()->json($datos, 200);
    }

    public function store(Request $request)
    {
        $mensaje = '';
        $codigo = 200;
        $boleta_disponible = Boleta::findOrFail($request->boleta_id);
        if ($boleta_disponible) {
            if ($request->cantidad <= $boleta_disponible->disponible && $boleta_disponible->disponible>0) {
                $reserva = new Reserva();
                $reserva->comprador_id = $request->comprador_id;
                $reserva->boleta_id = $request->boleta_id;
                $reserva->nombre_evento = $boleta_disponible->evento;
                $reserva->cantidad = $request->cantidad;
                if($reserva->save()){
                    $boleta_disponible->disponible = $boleta_disponible->disponible - $request->cantidad;
                    $boleta_disponible->save();
                    $mensaje = 'Asignacion realizada exitosamente';
                    $codigo = 201;
                }else{
                    $mensaje = 'ocurrio un problema al asignar';
                    $codigo = 400;
                }
            }else{
                $mensaje = 'No existe la disponibilidad solicitada';
                $codigo = 400;
            }
        }else{
            $mensaje = 'La boleta a asignar no existe';
            $codigo = 200;
        }

        return response()->json($mensaje, $codigo);
    }

}
