@extends('templates.base')
@section('head')
<title>Главная</title>
@stop
@section('background')
full
@stop

@section('content')
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-md-10 col-sm-10 card style-default-light">
        <img src="{{URL::asset('/img/AT3.png')}}" width="250px" class="center-block">
        <h2 class="text-default-dark text-center">Добро пожаловать, {{ Auth::user()['first_name'] }}!</h2>
        <h4 class="lead">Система находится в стадии первичного тестирования. Описание возникающих при работе проблем, а также замечания и предложения, просим направлять по нашему электронному адресу <b>algorithms.theory@yandex.ru</b></h4>
        <h4 class="lead"> На данный момент в различной степени готовности доступны следующие модули: </h4>
         <ul class="list-unstyled">
            <li> - <b>библиотека</b> (содержит все лекции, списки вопросов к экзамену, множество задач и очень много дополнительного материала, находится в состоянии пополнения и обновления) </li>
            <li> - <b>система тестирования</b></li>
            <li> - эмуляторы <b>машин Тьюринга</b> и <b>алгоритмов Маркова</b></li>
         </ul>
        <h4 class="lead"><b>Разработчики будут благодарны за активное тестирование системы, сообщения об ошибках, а также за пожелания по поводу функционала и интерфейса её модулей.</b></h4>

        @if( count($news) != 0)
            <h2 class="text-default-dark text-center">Новости</h2>
        @endif
        @foreach($news as $post)
            @if( $post['is_visible'] == 1)
                <div class="card card-bordered style-warning">
                    <div class="card-head">
                        <header><i class="fa fa-fw fa-tag"></i>{{ $post['title'] }}</header>
                    </div>
                    <div class="card-body style-default-bright">
                        <p>{{ $post['body'] }}</p>
                        @if($post['file_path'] != null)
                            {!! HTML::link($post['file_path'],'Скачать файл',array('class' => 'btn btn-primary btn-raised submit-question','role' => 'button')) !!}
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@stop