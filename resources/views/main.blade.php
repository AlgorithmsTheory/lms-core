@extends('templates.base')
@section('head')
<title>Главная</title>
@stop
@section('background')
full
@stop

@section('content')
    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-md-8 col-sm-8 card style-default-light">
        <img src="{{URL::asset('/img/AT3.png')}}" width="250px" class="center-block">
        <h1 class="text-default-dark text-center">Добро пожаловать, {{ Auth::user()['first_name'] }}!</h1>
        <h4 class="lead">Система находится в стадии первичного тестирования. Описание возникающих при работе проблем, а также замечания и предложения, просим направлять по нашему электронному адресу <b>algorithms.theory@yandex.ru</b></h4>
        <h4 class="lead"> На данный момент в различной степени готовности доступны следующие модули: </h4>
         <ul class="list-unstyled">
            <li> - <b>библиотека</b> (содержит все лекции, списки вопросов к экзамену, множество задач и очень много дополнительного материала, находится в состоянии пополнения) </li>
            <li> - <b>система тестирования</b> (содержит вопросы, аналогичные вопросам тестов, зачета и экзамена, в этом году используется для самоподготовки) </li>
            <li> - эмуляторы <b>машин Тьюринга</b> и <b>алгоритмов Маркова</b> (для подготовки к контрольным в этом году уже не пригодятся, но разработчики будут благодарны за тестирование их работы и сообщения об ошибках, а также за пожелания по поводу функционала и интерфейса) </li>
         </ul>
        <h4 class="lead"> Скорее за работу!</h4>

        @if( count($news) != 0)
            <h2 class="text-default-dark text-center">Новости</h2>
        @endif
        @foreach($news as $post)
            @if( $post['is_visible'] == 1)
                <div class="card card-bordered style-warning">
                    <div class="card-head">
                        <header><i class="fa fa-fw fa-tag"></i>{{ $post['title'] }}</header>
                    </div><!--end .card-head -->
                    <div class="card-body style-default-bright">
                        <p>{{ $post['body'] }}</p>
                    </div><!--end .card-body -->
                </div>
            @endif
        @endforeach
    </div>
@stop