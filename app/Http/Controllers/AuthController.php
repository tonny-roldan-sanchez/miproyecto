<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function mostrarDatos()
    {
        try {
            return response()->json(DB::connection('MySql2_LaragonLocal')->table('usuarios')->get());
        } catch (\Throwable $e) {
            return response()->json(['mensaje' => 'No se pudo consultar la tabla usuarios.'], 503);
        }
    }

    public function showLoginForm()
    {
        return view('AuthViews.InicioSesion');
    }

    public function login(Request $request)
    {

        $usuario = $request->usuario;
        $pass = $request->contrasennia;

        $resUsuario = DB::connection('MySqlUsuarios')
            ->table('usuarios')
            ->select('idUsuario', 'nombre', 'apellidos', 'contrasena')
            ->where('correo', $usuario)
            ->first();

        $contrasenaValida = $resUsuario
            && (Hash::check($pass, $resUsuario->contrasena)
                || hash_equals((string) $resUsuario->contrasena, (string) $pass));

        if ($contrasenaValida) {
            if (!str_starts_with((string) $resUsuario->contrasena, '$2y$')) {
                DB::connection('MySqlUsuarios')
                    ->table('usuarios')
                    ->where('idUsuario', $resUsuario->idUsuario)
                    ->update(['contrasena' => Hash::make($pass)]);
            }

            session()->put('id', $resUsuario->idUsuario);
            session()->put('nombreCompleto', trim($resUsuario->nombre . ' ' . $resUsuario->apellidos));
            return redirect('/profile');
        } else {
            return redirect('/login')
                ->with('loginCorecto', 'false')
                ->with('mensaje', 'Usuario o contraseña incorrectos');
        }
    }

    public function logout()
    {
        session()->forget('id');
        session()->forget('nombreCompleto');
        return redirect('/login');
    }
}
