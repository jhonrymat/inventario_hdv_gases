<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ubicacion;
use Illuminate\Support\Facades\Validator;

class UbicacionController extends Controller
{
    public function getlistaubicacion()
    {
        $ubicacion = ubicacion::all();

        return view('Ubicacion/lista', [
            'ubicacion' => $ubicacion
        ]);
    }
    public function create()
    {
        return view('Ubicacion/create');
    }

    public function createlistaubicacion(Request $request)
    {

        //validamos los datos
        $validate = Validator::make($request->all(), [
            'nombre'      => 'required',

        ]);

        if ($validate->fails()) {
            $request->session()->flash('alert-danger', 'Error al ingresar Ubicación');

            return redirect()->back();
        }
       
        $ubicacion = new ubicacion();
        $ubicacion->nombre = $request->input('nombre');

        $ubicacion->save();
        $request->session()->flash('alert-success', 'Ubicación registrado con exito!');


        return redirect()->route('listaubicacion.lista');
    }

    public function update($id)
    {
        $ubicacion = ubicacion::where('id', $id)->first();

        return view('Ubicacion/create', [
            'ubicacion' => $ubicacion
        ]);
    }

    public function updatelistaubicacion(Request $request, $listaubicacion_id)
    {

        $ubicacion = ubicacion::where('id', $listaubicacion_id)->first();

        //validamos los datos
        $validate = Validator::make($request->all(), [
            'nombre'      => 'required',
        ]);

        if ($validate->fails()) {
            $request->session()->flash('alert-danger', 'Error al ingresar ubicacion');

            return redirect()->back();
        }

        $ubicacion->nombre = $request->input('nombre');

        $ubicacion->save();

        $request->session()->flash('alert-success', 'Ubicacion actualizado con exito!');


        return redirect()->route('listaubicacion.lista');
    }
}
