<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">

            {{-- Con esta plantilla se editan las ordenes --}}
            <div class="col-md-12"><h2>Editar orden {{ $data['order']->id }}</h2></div>

            {{-- Se solicitan los datos necesarios para editar la orden. --}}
            <div class="col-md-12">
                <form method="post" action="/orders/{{ $data['order']->id}}" >
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">

                    <label for="total">Total</label>
                    <input type="number" step="0.01" name="total" value="{{ $data['order']->total }}">
                    <label for="impuestos">Impuestos</label>
                    <input type="number" step="0.01" name="impuestos" value="{{ $data['order']->impuestos }}">
                    <label for="estatus">Estatus</label>
                    <input type="text" name="estatus" value="{{ $data['order']->estatus }}">
                    <label for="comentarios">Comentarios</label>
                    <input type="text" name="comentarios" value="{{ $data['order']->comentarios }}">
                    
                    <label for="products">Productos</label>
                    @foreach ($data['products'] as $product)
                        @foreach ($data['order']->products as $item)
                            @if ($item->id == $product->id)
                                <input type="checkbox" id="{{ $product->id }}" name="proudcts_array[]" value="{{ $product->id }}" checked>
                                <label for="{{ $product->id }}">{{ $product->name }}</label><br>                                              
                                @break; 
                            @endif 
                        @endforeach
                        <input type="checkbox" id="{{ $product->id }}" name="proudcts_array[]" value="{{ $product->id }}">
                        <label for="{{ $product->id }}">{{ $product->name }}</label><br>                                          
                    @endforeach

                    <input type="hidden" name="id" value="{{ $data['order']->users()->first()->id }}">
                    <input type="submit" value="EDITAR">
                </form>
            </div>
        </div>
    </div>
</body>
</html>