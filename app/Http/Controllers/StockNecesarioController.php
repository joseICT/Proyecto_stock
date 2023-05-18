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
    public function list(){     
        $datos=DB::table('Stock_critico')->where([['Año','=', date('Y')],['Mes','=',date('m')],])->get();
        return view('StockNecesario',compact('datos'));
    }

    public function Search_ID($ID){
        //$datos=DB::table('Stock_critico') -> where ('Codigo','=',$ID)->get();

        //retornarlo a un modal
        //return view('StockNecesario',compact('datos'));
    }
}
