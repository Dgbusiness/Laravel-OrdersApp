<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class imprimirController extends Controller
{
    //
    public function imprimir($id){
        
        $order = Order::find($id);
        $pdf = \PDF::loadView('pages.imprimir', ['order' => $order]);
        return $pdf->download('imprimir.pdf');
    }
}
