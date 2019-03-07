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
        <h4 class="lead">Система поддержки обучения по курсу "Теория алгоритмов" позволяет:</h4>
        <ul class="list-results text-lg">
            <li>Проходить тренировочные и контрольные <b>тесты</b></li>
            <li>Читать <b>лекции</b> по курсу в удобном формате, заказывать дополнительную <b>литературу</b>, готовиться к <b>экзамену</b></li>
            <li>Тренироваться писать программы на <b>эмуляторах</b> Тьюринга, Маркова, Поста, RAM и рекурсии</li>
            <li>Отслеживать свои <b>результаты</b> в личном кабинете</li>
        </ul>
        <h4 class="lead">Описание возникающих при работе проблем, а также замечания и предложения, просим направлять по нашему электронному адресу <b>algorithms.theory@yandex.ru</b></h4>

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