<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boleta;

class BoletaController extends Controller
{
    /**
     * Listado de las boletas registradas
     */
    public function index()
    {
        $boletas = Boleta::all();
        return $boletas;
    }

    /**
     * Guardar una nueva Boleta con su cantidad
     */
    public function store(Request $request)
    {
        // Variables de informacion
        $mensaje = '';
        $codigo = 200;
        //bandera
        $continuar = true;
       //Validacion de los campos
        if (empty($request->evento)) {
            $mensaje = 'El nombre no debe estar vacio';
            $codigo = 400;
            $continuar = false;
        }else if (empty($request->disponible) || !is_numeric($request->disponible)) {
            $mensaje = 'La cantidad disponible debe ser numerica y no vacia';
            $codigo = 400;
            $continuar = false;
        }

        if ($continuar) {
            $boleta = new Boleta();
            $boleta->evento = $request->evento;
            $boleta->disponible = $request->disponible;
            if($boleta->save()){
                $mensaje = "Registro guardado exitosamente";
                $codigo = 201;
            }else{
                $mensaje = "Ocurrio un problema al guardar el registro";
                $codigo = 400;
            }
        }
        return response()->json($mensaje, $codigo);
    }
    /**
     * Obtenemos datos de una boleta y se devuelve al cliente
     */
    public function edit($id)
    {
        $boleta = Boleta::findOrFail($id);
        return response()->json($boleta, 201);
    }

    /**
     * Actualiza un registro 
     */
    public function update(Request $request, $id)
    {
        $mensaje = '';
        $codigo = 200;
        $continuar = true;

        $boleta = Boleta::find($id);
        //Si el registro a modificar existe
        if ($boleta) {
            //Validaciones de los campos
            if (empty($request->evento)) {
                $mensaje = 'El nombre no debe estar vacio';
                $codigo = 400;
                $continuar = false;
            }else if (empty($request->disponible) || !is_numeric($request->disponible)) {
                $mensaje = 'La cantidad disponible debe ser numerica y no vacia';
                $codigo = 400;
                $continuar = false;
            }
            
            if ($continuar) {
                $boleta->evento = $request->evento;
                $boleta->disponible = $request->disponible;
                if($boleta->save()){
                    $mensaje = "Registro Actualizado exitosamente";
                    $codigo = 201;
                }else{
                    $mensaje = "Ocurrio un problema al actualizar el registro";
                    $codigo = 400;
                }
            }
        }else{
            $mensaje = "El regisro que intentas actualizar, no existe. Por favor recarga la pagina";
            $codigo = 400;
        }
        return response()->json($mensaje, $codigo);
    }

    public function destroy(Request $request)
    {
        $mensaje = '';
        $boleta = Boleta::destroy($request->id);
        if ($boleta) {
            $mensaje = 'Registro eliminado exitosamente';
        }else{
            $mensaje = 'Ocurrio un problema al eliminar el registro';
            $codigo = 400;
        }
        return response()->json($mensaje, $codigo);
    }
}
