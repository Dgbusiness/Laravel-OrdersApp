<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class imprimirController extends Controller
{
    //Se imprime el pdf utilizando la información de la orden que se recibe.
    public function imprimir($id){
        
        $order = Order::find($id);
        $pdf = \PDF::loadView('pages.imprimir', ['order' => $order]);
        return $pdf->download('imprimir.pdf');
    }
}
