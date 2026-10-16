<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pacientesController extends Controller
{
	public function mostrarDatos()
	{
		try {
			return response()->json(DB::connection('MySql2_LaragonLocal')->table('users')->get());
		} catch (\Throwable $e) {
			return response()->json(['mensaje' => 'No se pudo consultar la tabla users.'], 503);
		}
	}
}
