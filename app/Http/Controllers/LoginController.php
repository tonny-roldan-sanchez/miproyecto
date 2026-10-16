<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LoginController extends Controller
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
