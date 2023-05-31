<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockNecesarioController extends Controller
{
    //verificar que esta logueado el usuario para poder ver la pagina
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Se lista toda la vista completa en los que sus meses y años sea igual al actual
    //actualizacion se modifico la vista y ahora entrega la media de ventas del año por producto
    //Se creo otra vista para evitar borrar la anterior
    public function list(){
        $datos=DB::table('Stock_critico_2')  
        ->get();
        return view('StockNecesario',compact('datos'));
    }

    public function Search_ID($id){

        //no funciona todavia
        //$registro=DB::table('Stock_critico')->where('Codigo','=',$id)->get();
        //return redirect('StockNecesario')->with(compact('registro'));
        //return Redirect::back()->with('',compact('datos'));
    }
}
