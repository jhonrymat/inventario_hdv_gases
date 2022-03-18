<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Lotes;
use App\Models\Productos;

class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getClientes($filtro = null)
    {

        if ($filtro == null)
            $Clientes = Clientes::all();
        else
            if ($filtro == 1) //mas reciente
            $clientes = Clientes::orderby('created_at', 'desc')->get();
        else
                if ($filtro == 2) //tipo
            $clientes = Clientes::where('tipo', 'fiscal')->orderby('created_at', 'asc')->get();
        else
                    if ($filtro == 3) //Alfabetico
            $clientes = Clientes::orderby('nombre', 'desc')->get();

        return view('Clientes/mostrar', [
            'clientes' => $Clientes
        ]);
    }

    public function create()
    {
        return view('Clientes/create');
    }

    public function createClientes(Request $request)
    {

        //validamos los datos
        $validate = Validator::make($request->all(), [
            'name'      => 'required',

        ]);

        if ($validate->fails()) {
            $request->session()->flash('alert-danger', 'Error almacenando los datos');

            return redirect()->back();
        }


        $Clientes = new Clientes();
        $Clientes->email = ' ';
        $Clientes->nombre =  $request->input('name');
        $Clientes->nit = ($request->input('tipo') == 'fiscal') ? $request->input('nit') : 'N/A';
        $Clientes->departamento = ($request->input('tipo') == 'fiscal') ? $request->input('departamento') : 'N/A';
        $Clientes->giro = ($request->input('tipo') == 'fiscal') ? $request->input('giro') : 'N/A';
        $Clientes->tipo = ($request->input('tipo') == 'fiscal') ? $request->input('tipo') : 'N/A';
        $Clientes->registro = ($request->input('tipo') == 'fiscal') ? $request->input('registro') : 'N/A';
        $Clientes->direccion = $request->input('direccion');



        $Clientes->save();

        $request->session()->flash('alert-success', 'Cliente registrado con exito!');

        return redirect()->route('clientes.lista');
    }

    public function update($id)
    {
        $Clientes = Clientes::where('id', $id)->first();

        return view('Clientes/create', [
            'cliente' => $Clientes
        ]);
    }

    public function updateClientes(Request $request, $Clientes_id)
    {

        $Clientes = Clientes::where('id', $Clientes_id)->first();

        //validamos los datos
        $validate = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required',

        ]);

        if ($validate->fails()) {
            $request->session()->flash('alert-danger', 'Error almacenando los datos');

            return redirect()->back();
        }

        $Clientes->email = ' ';
        $Clientes->nombre =  $request->input('name');
        $Clientes->nit = ($request->input('tipo') == 'fiscal') ? $request->input('nit') : 'N/A';
        $Clientes->departamento = ($request->input('tipo') == 'fiscal') ? $request->input('departamento') : 'N/A';
        $Clientes->giro = ($request->input('tipo') == 'fiscal') ? $request->input('giro') : 'N/A';
        $Clientes->tipo = ($request->input('tipo') == 'fiscal') ? $request->input('tipo') : 'N/A';
        $Clientes->registro = ($request->input('tipo') == 'fiscal') ? $request->input('registro') : 'N/A';
        $Clientes->direccion = $request->input('direccion');
        $Clientes->save();

        $request->session()->flash('alert-success', 'Cliente actualizado con exito!');


        return redirect()->route('clientes.lista');
    }

    public function getOneClient(Request $request)
    {

        $dui = $request->input('dui');
        $cliente = Clientes::where('dui', $dui)->first();

        $productos = Productos::all();

        $lotes = Lotes::all();

        return view('ventas/create', [
            'cliente' => $cliente
        ]);
    }


    public function deleteClientes()
    {
    }
}
