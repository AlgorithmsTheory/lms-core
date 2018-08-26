@extends('templates.base')
@section('head')
    <title>Новости библиотеки</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/libs/utils/html5shiv.js') !!}
    {!! HTML::script('js/libs/utils/respond.min.js') !!}
    <![endif]-->

@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('books', 'Бронирование печатных изданий') !!}</li>
                            @if($role == 'Админ' or $role == 'Преподаватель')
                            <li class="active">Управление библиотечными новостями</li>
                                @else
                                <li class="active">Новости библиотеки</li>
                                @endif
                        </ol>
                    </div><!--end .section-header -->
                </section>
            </div>
            <div class="col-lg-4">
                @if($role == 'Админ' or $role == 'Преподаватель')
                {!! HTML::link('library/books/create','Добавить книгу',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                    {!! HTML::link('library/books/teacherCabinet','Личный кабинет',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                    @else
                    {!! HTML::link('library/books/studentCabinet','Личный кабинет',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                @endif

                <div>
        </div>
    </div>

    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card">
            <div class="card-body">
                @if($role == 'Админ' or $role == 'Преподаватель')
                <h2 class="text-center">Редактирование новостей</h2>
                @endif
                @foreach($news as $post)
                    <div class="card card-bordered {{ 'style-warning' }}" id="{{ $post->id }}">
                        <div class="card-head">
                            <header><i class="glyphicon glyphicon-sunglasses"></i>  {{ $post->title }}</header>
                            <div class="tools">
                                @if($role == 'Админ' or $role == 'Преподаватель')
                                <div class="btn-group">
                                    <a class="btn btn-icon-toggle " name="{{ $post->id }}" href="{{ action('BooksController@editNewsLibrary', [$post->id])}}"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                                <div class="btn-group ">
                                    <button type="submit" class="btn btn-icon-toggle  delete_library_news" value="{{ csrf_token() }}" id="delete{{ $post->id }}">
                                        <i class="md md-close"></i></button>
                                </div>
                                @endif
                            </div>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <p>{{ $post->description }}</p>
                        </div><!--end .card-body -->
                    </div>
                @endforeach

                <hr>
                    @if($role == 'Админ' or $role == 'Преподаватель')
                <form action="{{URL::route('add_library_news')}}" method="POST" class="form" role="form" id="form_add_news">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form">
                        <div class="form-group">
                            <textarea name="title" id="title_add_news" class="form-control" rows="3" placeholder="" required></textarea>
                            <label for="textarea1">Заголовок новости</label>
                        </div>

                        <div class="form-group">
                            <textarea name="description" id="body_add_news" class="form-control" rows="3" placeholder="" required></textarea>
                            <label for="textarea1">Текст новости</label>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить новость</button>
                        </div>
                    </div>
                </form>
                    @endif

            </div>
        </div>

    </div>

@stop
@section('js-down')
    <!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/libs/spin.js/spin.min.js') !!}
    {!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
    {!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/library/manage_library_news.js') !!}
    <script>


    </script>
    <!-- END JAVASCRIPT -->
@stop
