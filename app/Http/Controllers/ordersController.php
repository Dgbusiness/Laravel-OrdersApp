<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
use CreateUserOrder;
use Illuminate\Http\Request;

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
        //
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
        //
        $this->validate($request, [
            'total'=>'required',
            'impuestos'=> 'required',
            'comentarios'=> 'required',
            'proudcts_array' => 'required',
            'id' => 'required',
        ]);

        $user = User::find($request->input('id'));

        $order = new Order();
        $order->total = $request->input('total');
        $order->impuestos = $request->input('impuestos');
        $order->estatus = $request->input('estatus');
        $order->comentarios = $request->input('comentarios');
        $order->save();

        $productsID = $request->input('proudcts_array');
        $products = array();
        foreach ((array) $productsID as $id) {
            $product = Product::find($id);
            array_push($products, $product);
        }
        $order->users()->attach($user);
        foreach ($products as $product ) {
            $order->products()->attach($product);            
        }        
        
        //\Mail::to($user->email)->send(new \App\Mail\OrderCreatedMail());       
        
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
        //
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
        //
        $this->validate($request, [
            'total'=>'required',
            'impuestos'=> 'required',
            'comentarios'=> 'required',
            'proudcts_array' => 'required',
        ]);


        $order = Order::find($id);
        $order->total = $request->input('total');
        $order->impuestos = $request->input('impuestos');
        $order->estatus = $request->input('estatus');
        $order->comentarios = $request->input('comentarios');
        $order->save();

        $productsID = $request->input('proudcts_array');
        $products = array();
        foreach ((array) $productsID as $id) {
            $product = Product::find($id);
            array_push($products, $product);
        }

        foreach ($order->products as $product ) {
            $order->products()->detach($product);
        }

        foreach ($products as $product ) {
            $order->products()->attach($product);            
        }        
        
        //\Mail::to($user->email)->send(new \App\Mail\OrderCreatedMail());       
        
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
        $order = Order::find($id);

        $user = $order->users()->first();

        $order->users()->detach($user);
        foreach ($order->products as $product ) {
            $order->products()->detach($product);
        }

        $order->delete();

        return redirect('/'.$user->id.'/show');
    }
}
