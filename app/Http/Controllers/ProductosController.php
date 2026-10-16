<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    public function mostrarDatos()
    {
        try {
            return response()->json(DB::connection('MySql2_LaragonLocal')->table('camiones')->get());
        } catch (\Throwable $e) {
            return response()->json(['mensaje' => 'No se pudo consultar la tabla camiones.'], 503);
        }
    }

    public function index(){
        echo "Página principal de productos";
    }
    public function create(){ //Muestra un formulario para crear un nuevo recurso
        echo "Formulario para crear un nuevo producto";
    }
    public function store(Request $request ){ //Guarda un nuevo recurso en la base de datos
        echo "Página para guardar un nuevo producto usando los siguientes datos que llegan de un formualrio";

        dd($request->all());
    }

    public function show($id){ //Muestra un recurso específico
        echo "Página para mostrar el producto con el id=$id";
    }

    public function search(Request $request){ //Muestra un recurso específico
        echo "Página para busqueda avanzada usando los siguientes parámetros de query:<br>";

        $datos=$request->all();

        echo "Variables de Query<br>";
        foreach ($datos as $clave=> $valor){
            echo "Variable: {$clave}.    valor={$valor} <br>";
        }

        dd($request->all());
    }

    public function edit($id){ //Muestra el formulario para editar un recurso
        echo "Formulario para editar el producto con id={$id}";

    }

    public function update(Request $request, $id){ //Actualiza el recurso en la base de datos
        echo "Página para editar el producto con el id ={$id} usando los siguiente valores:";
        dd($request->all());
    }

    public function destroy($id){ //Elimina un recurso de al base de datos
        echo "Página para eliminar el producto con el id=$id";
    }


}
