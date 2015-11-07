<html xmlns="http://www.w3.org/1999/html" >
<head>
    <title>Главная</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/tests_list.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::script('js/jquery.js') !!}
</head>
<body class="full">
<section>
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="text-default-bright">Добро пожаловать, {{ $first_name }}!</h1>
    </div>
    <div class="section-body">

        <div class="col-lg-offset-2 col-md-8 col-sm-8 card style-default-light">
            <h3 class="lead">Вы находитесь на электронном ресурсе, посвященном курсу по "Теории алгоритмов". Здесь вы можете проходить разлиные тестирования, пользоваться ресурсами электронной библиотеки, пользоваться эмуляторами Машин Тьюринга и Алгоритмов Маркова. Скорее за работу!</h3>
        </div>

        <div class="row">
            <a href="{{URL::route('tests')}}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">Перейти к системе тестирования</a>
        </div>
        <br>
        <div class="row">
            <a href="#" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">Перейти к электронной библтотеке</a>
        </div>
        <br>
        <div class="row">
            <a href="#" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">Перейти к эмуляторам Машин Тьюринга</a>
        </div>
        <br>
        <div class="row">
            <a href="#" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">Перейти к эмуляторам Алгоритмов Маркова</a>
        </div>

    </div>
</section>

{!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
{!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
{!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
</body>
</html>