<!DOCTYPE html>
<html lang="en">
<style>
    .col-md-12 {
        border-radius: 2vh;
        background-color:rgba(205, 223, 254, 0.4);
        padding-top: 1vh;
        padding-bottom: 1vh;
    }
    .col-md-8, .row{
        padding-top: 1vh;
        padding-bottom: 1vh;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">

            {{-- Nombre del usuario con la opción para crear nuevas ordenes. --}}
            <div class="col-md-12">
                <h2>Usuario: {{ $data['user']->name }}</h2>
                <button><a href="/{{ $data['user']->id }}/create">CREAR ORDEN</a></button>
            </div>

            {{-- Se listan todas lar ordenes asociadas al usuario --}}
            <div class="col-md-12">
                <div class="row">
                    @if ($data['user']->orders())
                        <div class="col-md-8 row">
                            <div class="col-md-3">Estatus</div>
                            <div class="col-md-3">Total</div>
                            <div class="col-md-3">Impuestos</div>
                            <div class="col-md-3">Comentarios</div>  
                        </div>
                        @foreach ($data['user']->orders as $order)
                            <div class="col-md-8 row">
                                <div class="col-md-3">{{ $order->estatus }}</div>
                                <div class="col-md-3">{{ $order->total }}</div>
                                <div class="col-md-3">{{ $order->impuestos }}</div>
                                <div class="col-md-3">{{ $order->comentarios }}</div>  
                                <div class="col-md-12">
                                    Listado de Productos
                                    @foreach ($order->products as $product)
                                        <div class="col-md-3">{{ $product->name }}</div>
                                    @endforeach                          
                                </div>
                            </div>

                            {{-- Botones para editar, eliminar y descargar detalles de ordenes en PDF --}}
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('imprimir', ['id' => $order->id]) }}">DESCARGAR PDF</a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('orders.edit', ['order' => $order]) }}">EDITAR</a>
                                    </div>
                                    <div class="col-md-3">
                                        <form action="/orders/{{ $order->id }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <input type="submit" value="ELIMINAR">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach            
                    @else
                        <h4><strong>ESTE USUARIO NO TIENE ORDENES AÚN.</strong></h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>