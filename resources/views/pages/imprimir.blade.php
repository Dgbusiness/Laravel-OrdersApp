<h2>Orden ID: {{ $order->id }}</h2>
<h2>Usuario: {{ $order->users()->first()->name }}</h2>
<h2>Estatus: {{ $order->estatus }}</h2>
<h2>Total: {{ $order->total }}</h2>
<h2>Impuestos: {{ $order->impuestos }}</h2>
<h2>Lista de productos:</h2>
@foreach ($order->products as $product)
    <h4>{{ $product->name }}</h4>
@endforeach
<h2>Comentarios: {{ $order->comentarios }}</h2>
