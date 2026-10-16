<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InicioSesionController extends Controller
{
    public function mostrarDatos()
    {
        try {
            return response()->json(DB::connection('MySql2_LaragonLocal')->table('usuarios')->get());
        } catch (\Throwable $e) {
            return response()->json(['mensaje' => 'No se pudo consultar la tabla usuarios.'], 503);
        }
    }
}
