<?php

namespace App\Http\Controllers;

use App\Notifications\OrderCreatedNotification;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
use CreateUserOrder;
use Illuminate\Http\Request;
use Notification;

use function Psy\debug;

class ordersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //Trae la vista para crear una nueva orden, mandando como parametros la lista de productos
        //y el usuario.
        $user = User::find($id);
        $products = Product::get();
        return view('pages.create')->with('data', ['user' => $user, 'products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Se valida los parametros para la creacion de la orden
        $this->validate($request, [
            'total'=>'required',
            'impuestos'=> 'required',
            'comentarios'=> 'required',
            'proudcts_array' => 'required',
            'id' => 'required',
        ]);

        //Se busca al usuario al que se le asociará la orden.
        $user = User::find($request->input('id'));

        //Se crea y almacena la nueva orden.
        $order = new Order();
        $order->total = $request->input('total');
        $order->impuestos = $request->input('impuestos');
        $order->estatus = $request->input('estatus');
        $order->comentarios = $request->input('comentarios');
        $order->save();

        //Se crea un arreglo de los productos seleccionados para actualizar la tabla pivote.
        $productsID = $request->input('proudcts_array');
        $products = array();
        foreach ((array) $productsID as $id) {
            $product = Product::find($id);
            array_push($products, $product);
        }

        //Se actualizan las tablas pivote (userOrder y orderProduct)
        $order->users()->attach($user);
        foreach ($products as $product ) {
            $order->products()->attach($product);            
        }   
        

        //En esta sección se intentó realizar el envio de la notificacion de creacion al usuario
        //por Notification y por Mail (ambos dieron error de autentificación con gmail)
        $details = [
            'userName' => $user->name,
        ];


        Notification::send($user, new OrderCreatedNotification($details));
        
        //\Mail::to($user->email)->send(new \App\Mail\OrderCreatedMail());  
        
        //Finalmente, redireccionamos a la lista de ordenes del usuario.
        $route = '/'.$user->id.'/show';
        return redirect($route);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Buscamos la plantilla para editar una orden, enviando como parametros la orden y 
        //la lista de productos para comparar que productos estan seleccionados en la orden,
        //de manera tal que se puedan listar todos los productos y seleccionar los correspondientes.
        $order = Order::find($id);
        $products = Product::get();
        return view('pages.edit')->with('data', ['order' => $order, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Se validan los parametros para la edicion
        $this->validate($request, [
            'total'=>'required',
            'impuestos'=> 'required',
            'comentarios'=> 'required',
            'proudcts_array' => 'required',
        ]);

        //El proceso es similar a la creación, con la diferencia de que ya conocemos al usuario
        //y hay que buscar la orden en vez de crearla.
        $order = Order::find($id);
        $order->total = $request->input('total');
        $order->impuestos = $request->input('impuestos');
        $order->estatus = $request->input('estatus');
        $order->comentarios = $request->input('comentarios');
        $order->save();

        //Creamos el arreglo de productos seleccionados.
        $productsID = $request->input('proudcts_array');
        $products = array();
        foreach ((array) $productsID as $id) {
            $product = Product::find($id);
            array_push($products, $product);
        }
        
        //Solo actualizaremos la tabla pivote de orderProducts, pero antes la limpiamos para que no hayan
        //entradas duplicadas
        foreach ($order->products as $product ) {
            $order->products()->detach($product);
        }

        foreach ($products as $product ) {
            $order->products()->attach($product);            
        }        
        
        //Redireccionamos a la lista de ordenes del usuario.
        $route = '/'.$order->users()->first()->id.'/show';
        return redirect($route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Se busca la orden a eliminar
        $order = Order::find($id);

        $user = $order->users()->first();

        //borramos las asociaciones del usuario con la orden de la tabla pivote userOrder
        $order->users()->detach($user);
        
        //borramos las asociaciones de la orden con los productos de la tabla pivote orderProduct
        foreach ($order->products as $product ) {
            $order->products()->detach($product);
        }

        //Eliminamos la orden
        $order->delete();

        //Redireccionamos a la lista de ordenes del usuario.
        return redirect('/'.$user->id.'/show');
    }
}
