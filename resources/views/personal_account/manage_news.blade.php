@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Новости</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('background')
    full
@stop

@section('content')
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center">Добавить или удалить новость</h2>
                @foreach($news as $post)
                    <div class="card card-bordered {{ $post['is_visible'] == 1 ? 'style-warning' : 'style-gray-bright' }}" id="{{ $post['id'] }}">
                        <div class="card-head">
                            <header><i class="fa fa-fw fa-tag"></i>{{ $post['title'] }}</header>
                            <div class="tools">
                                <div class="btn-group">
                                    <a class="btn btn-icon-toggle btn-close show" name="{{ $post['id'] }}"><i class="md md-remove-red-eye"></i></a>
                                </div>
                                <div class="btn-group ">
                                    <a class="btn btn-icon-toggle btn-close delete" name="{{ $post['id'] }}"><i class="md md-close"></i></a>
                                </div>
                            </div>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <p>{{ $post['body'] }}</p>
                            @if($post['file_path'] != null)
                                {!! HTML::link($post['file_path'],'Скачать файл',array('class' => 'btn btn-primary btn-raised submit-question','role' => 'button')) !!}
                            @endif
                        </div><!--end .card-body -->
                    </div>
                @endforeach

                <hr>
                <form action="{{URL::route('add_news')}}" method="POST" class="form" role="form"
                      enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form">
                        <div class="form-group">
                            <textarea name="title" id="title" class="form-control" rows="3" placeholder=""></textarea>
                            <label for="textarea1">Заголовок новости</label>
                        </div>

                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" rows="3" placeholder=""></textarea>
                            <label for="textarea1">Текст новости</label>
                        </div>

                        <div class="form-group">
                            <input type="file" class="form-control-file" name="file" >

                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить новость</button>
                        </div>
                    </div>
                </form>
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>

    </div>
    {!! HTML::script('js/personal_account/delete_news.js') !!}

@stop