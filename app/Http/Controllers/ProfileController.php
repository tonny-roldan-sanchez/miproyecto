<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function mostrarDatos()
    {
        try {
            $usuarios = DB::connection('MySqlUsuarios')
                ->table('usuarios')
                ->orderBy('idUsuario')
                ->get(['idUsuario', 'nombre', 'apellidos', 'correo', 'telefono', 'contrasena'])
                ->map(function ($usuario) {
                    return [
                        'id_usuario' => $usuario->idUsuario,
                        'nombre' => $usuario->nombre,
                        'apellidos' => $usuario->apellidos,
                        'usuario' => $usuario->correo,
                        'email' => $usuario->correo,
                        'telefono' => $usuario->telefono,
                        'contrasena' => '********',
                    ];
                })
                ->all();

            $_SESSION['usuario'] = [
                'nombre' => 'Usuario',
                'rol' => 'Usuario',
                'foto' => '/dist/img/avatar.png',
            ];

            ob_start();
            include base_path('views/PerfilView.php');
            return response(ob_get_clean());
        } catch (\Throwable $e) {
            report($e);
            return response('No se pudo cargar el perfil.', 503);
        }
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:50'],
            'apellidos' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'email', 'max:100'],
            'telefono' => ['required', 'string', 'max:15'],
            'contrasena' => ['required', 'string', 'min:4'],
        ]);

        DB::connection('MySqlUsuarios')->table('usuarios')->insert([
            'nombre' => $datos['nombre'],
            'apellidos' => $datos['apellidos'],
            'correo' => $datos['correo'],
            'telefono' => $datos['telefono'],
            'contrasena' => Hash::make($datos['contrasena']),
        ]);

        return redirect('/datos/perfil')->with('mensaje_perfil', 'Usuario creado correctamente.');
    }

    public function update(Request $request, int $id)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:50'],
            'apellidos' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'email', 'max:100'],
            'telefono' => ['required', 'string', 'max:15'],
            'contrasena' => ['nullable', 'string', 'min:4'],
        ]);

        $actualizacion = [
            'nombre' => $datos['nombre'],
            'apellidos' => $datos['apellidos'],
            'correo' => $datos['correo'],
            'telefono' => $datos['telefono'],
        ];

        if (!empty($datos['contrasena'])) {
            $actualizacion['contrasena'] = Hash::make($datos['contrasena']);
        }

        DB::connection('MySqlUsuarios')
            ->table('usuarios')
            ->where('idUsuario', $id)
            ->update($actualizacion);

        return redirect('/datos/perfil')->with('mensaje_perfil', 'Usuario actualizado correctamente.');
    }

    public function destroy(int $id)
    {
        DB::connection('MySqlUsuarios')
            ->table('usuarios')
            ->where('idUsuario', $id)
            ->delete();

        return redirect('/datos/perfil')->with('mensaje_perfil', 'Usuario eliminado correctamente.');
    }

    public function showProfileForm(){
        //Formulario del cpanel para mostrar profile
        if (session()->has('nombreCompleto')) {
            $nomnreCompleto=session()->get('nombreCompleto');
            return view('ProfileViews.perfildeusuario',['nomnreCompleto'=>$nomnreCompleto]);
        }
        else
            return redirect('/login')
                ->with('loginCorecto', 'false')
                ->with('mensaje', 'Su sesión ha caducado');
    }

    public function edit($id){

    }

}
