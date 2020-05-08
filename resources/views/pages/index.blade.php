<!DOCTYPE html>
<html lang="en">
<style>
    .row{
        border-radius: 2vh;
        background-color:rgba(128, 128, 128, 0.4);
        padding-top: 1vh;
        padding-bottom: 1vh;
    }

    a {
        color: black;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    {{-- Se listan los usuarios. --}}
    <div class="container">
        <h1>Lista de usuarios</h1>
    </div>

    
    <div class="container">
        @foreach ($users as $user)           
            <div class="row"><h3><a href="/{{ $user->id }}/show">{{ $user->name }}</a></h3></div>
        @endforeach
    </div>
</body>
</html>