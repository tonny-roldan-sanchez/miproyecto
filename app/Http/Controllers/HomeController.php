<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Codificador;

class HomeController extends Controller
{
    public function mostrarDatos()
    {
        try {
            $tablas = [
                'usuarios', 'accesos', 'apartados', 'camiones', 'espacios', 'historial', 'pagos',
            ];
            $datos = [];

            foreach ($tablas as $tabla) {
                $datos[$tabla] = DB::connection('MySql2_LaragonLocal')->table($tabla)->get();
            }

            return response()->json($datos);
        } catch (\Throwable $e) {
            return response()->json(['mensaje' => 'No se pudieron consultar las tablas.'], 503);
        }
    }

//    public function index(){
//        return "Página principal del podcast de TICS desde un controlador";
//    }

    public function __invoke(){
    //return view("login");
    return redirect()->route('login');

        //$roles = DB::select('SELECT * FROM roles WHERE id = ?', [$id]);
        //DB::insert('INSERT INTO roles (nombre_rol) VALUES (?)', ['Residente']);
        //DB::update('UPDATE roles SET nombre_rol = ? WHERE id = ?', ['Servicio Social', 7]);
        //DB::delete('DELETE FROM roles WHERE id = ?', [7]);
        //dd($usuarios);
        //return $roles;
        //return "Página principal del podcast de TICS desde un controlador";
    }
}
