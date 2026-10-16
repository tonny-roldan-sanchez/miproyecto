<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    public function mostrarDatos()
    {
        try {
            return response()->json(DB::connection('MySql2_LaragonLocal')->table('historial')->get());
        } catch (\Throwable $e) {
            return response()->json(['mensaje' => 'No se pudo consultar la tabla historial.'], 503);
        }
    }
}
