<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comprador;
use Illuminate\Support\Facades\DB;

class CompradorController extends Controller
{

    public function index()
    {
        $compradores = Comprador::all();
        return $compradores;
    }

    public function store(Request $request)
    {
        $mensaje = '';
        $codigo = 200;
        $continuar = true;
       
        if (empty($request->nombre)) {
            $mensaje = 'El nombre no debe estar vacio';
            $codigo = 400;
            $continuar = false;
        }else if (empty($request->apellido)) {
            $mensaje = 'El apellido no debe estar vacio';
            $codigo = 400;
            $continuar = false;
        }else if (empty($request->identificacion) || !is_numeric($request->identificacion)) {
            $mensaje = 'La identificacion esta vacia o tiene un formato no valido';
            $codigo = 400;
            $continuar = false;
        }else if (empty($request->telefono) || !is_numeric($request->telefono)) {
            $mensaje = 'El telefono no debe estar vacio o tiene un formato no valido';
            $codigo = 400;
            $continuar = false;
        }

        if ($continuar) {

            $duplicado = DB::table('comprador')->where('identificacion', '=', $request->identificacion)->get()->toArray();
            if ($duplicado) {
                $mensaje = 'La identificacion ya existe en el sistema, intente con una distinta';
                $codigo = 428;
                $continuar = false;
            }else{
                $comprador = new Comprador();
                $comprador->nombre = $request->nombre;
                $comprador->apellido = $request->apellido;
                $comprador->identificacion = $request->identificacion;
                $comprador->telefono = $request->telefono;
                if($comprador->save()){
                    $mensaje = "Registro guardado exitosamente";
                    $codigo = 201;
                }else{
                    $mensaje = "Ocurrio un problema al guardar el registro";
                    $codigo = 400;
                }
            }
        }

        return response()->json($mensaje, $codigo);
    }

    public function edit($id)
    {
        $comprador = Comprador::findOrFail($id);
        return $comprador;
    }

    public function update(Request $request, $id)
    {
        $mensaje = '';
        $codigo = 200;
        $continuar = true;

        $comprador = Comprador::find($id);
        if ($comprador) {
            if (empty($request->nombre)) {
                $mensaje = 'El nombre no debe estar vacio';
                $codigo = 400;
                $continuar = false;
            }else if (empty($request->apellido)) {
                $mensaje = 'El apellido no debe estar vacio';
                $codigo = 400;
                $continuar = false;
            }else if (empty($request->identificacion) || !is_numeric($request->identificacion)) {
                $mensaje = 'La identificacion esta vacia o tiene un formato no valido';
                $codigo = 400;
                $continuar = false;
            }else if (empty($request->telefono) || !is_numeric($request->telefono)) {
                $mensaje = 'El telefono no debe estar vacio o tiene un formato no valido';
                $codigo = 400;
                $continuar = false;
            }
    
            $comprador->nombre = $request->nombre;
            $comprador->apellido = $request->apellido;
            $comprador->telefono = $request->telefono;
    
            if($comprador->save()){
                $mensaje = "Registro Actualizado exitosamente";
                $codigo = 201;
            }else{
                $mensaje = "Ocurrio un problema al actualizar el registro";
                $codigo = 400;
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
        $codigo = 200;
        
        $comprador = Comprador::destroy($request->id);
        if ($comprador) {
            $mensaje = 'Registro eliminado exitosamente';
        }else{
            $mensaje = 'Ocurrio un problema al eliminar el registro';
            $codigo = 400;
        }
        return response()->json($mensaje, $codigo);
    }
}
