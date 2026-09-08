<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pacientesController;
#use App\Http\
Route:: get('/',function(){
    return view('inicio');
});
Route:: get('/',function(){
    return view('pacientes');/// vista llamada pacientes 
});
Route:: get('/login',function(){
    return view('AuthView.InicioSesion');/// vista llamada pacientes 
});

