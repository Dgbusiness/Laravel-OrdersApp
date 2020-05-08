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
            <div class="col-md-12"><h2>Nueva orden para {{ $data['user']->name }}</h2></div>
            <div class="col-md-12">
                <form method="post" action="/orders" >
                    {{ csrf_field() }}
                    <label for="total">Total</label>
                    <input type="number" step="0.01" name="total">
                    <label for="impuestos">Impuestos</label>
                    <input type="number" step="0.01" name="impuestos">
                    <label for="estatus">Estatus</label>
                    <input type="text" name="estatus">
                    <label for="comentarios">Comentarios</label>
                    <input type="text" name="comentarios">
                    
                    <label for="products">Productos</label>
                    @foreach ($data['products'] as $product)
                        <input type="checkbox" id="{{ $product->id }}" name="proudcts_array[]" value="{{ $product->id }}">
                        <label for="{{ $product->id }}">{{ $product->name }}</label><br>              
                    @endforeach

                    <input type="hidden" name="id" value="{{ $data['user']->id }}">
                    <input type="submit" value="Crear">
                </form>
            </div>
        </div>
    </div>
</body>
</html>