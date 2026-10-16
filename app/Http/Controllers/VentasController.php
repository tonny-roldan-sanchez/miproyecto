<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    public function mostrarDatos()
    {
        try {
            return response()->json(DB::connection('MySql2_LaragonLocal')->table('pagos')->get());
        } catch (\Throwable $e) {
            return response()->json(['mensaje' => 'No se pudo consultar la tabla pagos.'], 503);
        }
    }

    public function index(){
        return view('ventas');
    }
}
