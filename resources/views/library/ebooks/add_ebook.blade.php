@extends('templates.base')
@section('head')
    <title>Добавление новой книги</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <!-- END META -->

@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('ebooks', 'Электронные книги') !!}</li>
                            <li class="active">Добавление новой электронной книги</li>
                        </ol>
                    </div><!--end .section-header -->
                </section>
            </div>
        </div>
    </div>
    <div class="card card-tiles style-default-light">
        <br>
        <div class ="container-fluid">
            <div class="col-lg-1 col-md-1">
            </div>
            <div class="col-lg-11 col-md-11">

                {!! Form::open(array('action' => 'LibraryController@storeEbook', 'files' => true)) !!}
                <div class="form-group">
                   <h4> {!! Form::label('ebook_title', 'Название книги:') !!}</h4>
                    {!! Form::text('ebook_title',null,['class' => 'form-control','placeholder' => 'Введите название книги']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('ebook_author', 'Автор книги:') !!}</h4>
                    {!! Form::text('ebook_author',null,['class' => 'form-control','placeholder' => 'Введите автора книги']) !!}

                </div>
                <div class="form-group">
                    <h4> {!! Form::label('id_genre', 'Жанр книги:') !!}</h4>
                    {!! Form::select('id_genre',array('' =>'Выберите жанр книги:',
                    '1' => 'Теория графов', '2' => 'Принятие решений и мягкие вычисления',
                    '3' => 'Логистика и экономико-математические методы',
                    '4' => 'Информационные технологии в образовании',
                    '5' => 'Научно-популярная литература',
                    '6' => 'Дискретная математика',
                    '7' => 'Теория алгоритмов и сложности вычислений'), null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('ebook_desc', 'Описание книги:') !!}</h4>
                    {!! Form::textarea('ebook_desc',null,['class' => 'form-control','placeholder' => 'Введите описание книги']) !!}

                </div>
                <div class="form-group">
                    <h4> <label for="ebook_img">Выберите изображение (Обяз.)</label></h4>
                    <input type="file" class="form-control-file" name="ebook_img" >
                </div>
                <div class="form-group">
                    <h4> <label for="ebook_file">Выберите файл книги в формате doc,docx,pdf,djvu (Обяз.)</label></h4>
                    <input type="file" class="form-control-file" name="ebook_file" >
                </div>
                <div class="form-group">
                    <button type="submit" class=" btn ink-reaction btn-primary">Добавить книгу</button>
                </div>
                {!! Form::close() !!}
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
@stop
@section('js-down')
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
@stop