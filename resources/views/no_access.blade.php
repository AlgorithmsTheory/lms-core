<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Ошибка доступа</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
</head>

<body class="full-no_access">
<section>
    <div class="col-md-12 col-sm-6 card style-danger">
        <h1 class="text-default-bright">У вас нет прав на просмотр данной страницы</h1>
    </div>
    <div class="row">
        <a href="{{URL::route('home')}}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">Перейти на главную</a>
    </div>
</section>
</body>
</html>