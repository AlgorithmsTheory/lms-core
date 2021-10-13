@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Список вопросов</title>
<style>
    #find:hover{
        background-color: #db8300;
        color: #ffffff;
        border-color: #db8300
    }
</style>
@stop

@section('content')
<div class="col-md-12 col-sm-6 card style-primary text-center">
    <h1 class="">Список вопросов</h1>
</div>

<div class="card col-lg-offset-0 col-md-12 col-sm-6">
    <div class="card-body">
        <div class="form">
            <form action="{{URL::route('questions_find')}}" method="POST" class="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-6 floating-label">
                    <input name="title" type="text" class="form-control" id="title" value="{{ $filter_query }}">
                    <label for="title">Текст вопроса</label>
                </div>
                <div class="form-group col-md-6">
                    <select name="section" id="section" class="form-control" size="1" required>
                        <option value="Все">Все</option>
                        @foreach ($sections as $section)
                        <option value="{{ $section['section_name'] }}" {{ $filter_section == $section['section_name'] ? 'selected' : '' }}>{{ $section['section_name'] }}</option>
                        @endforeach
                    </select>
                    <label for="section">Раздел</label>
                </div>
                <div class="form-group col-md-6" id="theme-container">
                    <!-- контейнер для подгрузки темы -->
                </div>
                <div class="form-group col-md-6">
                    <select name="type" id="type" class="form-control" size="1">
                        <option value="Все">Все</option>
                        @foreach ($types as $type)
                        <option value="{{ $type['type_name'] }}" {{ $filter_type == $type['type_name'] ? 'selected' : '' }}>{{ $type['type_name'] }}</option>
                        @endforeach
                    </select>
                    <label for="type">Тип</label>
                </div>
                <div class="col-sm-6">
                    <input id="find" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary"
                           type="submit" name="find" value="Найти">
                </div>
            </form>
        </div>
    </div>
</div>

<?php $i = 0 ?>
@foreach($questions as $question)
    <div class="col-md-12">
        <div class="card card-bordered style-primary card-collapsed">
            <div class="card-head">
                <div class="tools">
                    <div class="btn-group">
                        <a href="{{URL::route('question_edit', array($question['id_question']))}}" class="btn btn-icon-toggle dropdown-toggle"><i class="md md-colorize"></i></a>
                        <a href="{{URL::route('question_profile', array($question['id_question']))}}" class="btn btn-icon-toggle dropdown-toggle"><i class="md md-insert-chart"></i></a>
                        <a class="btn btn-icon-toggle btn-collapse"><i class="md md-keyboard-arrow-down"></i></a>
                        <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                    </div>
                </div>
                <header>
                    Тема: {{ $question['theme'] }} <br>
                    Текст: {{ substr($question['title'], 0, 160) }}
                </header>
            </div><!--end .card-head -->
            <div class="card-body style-default-bright" style="display: none">
                <p><?php echo $widgets[$i]; $i++ ?></p>
            </div><!--end .card-body -->
        </div><!--end .card -->
    </div>
@endforeach
{!! $questions->appends(['title' => Input::get('title'), 'section' => Input::get('section'), 
                         'theme' => Input::get('theme'), 'type' => Input::get('type')])
              ->render() !!}
@stop

@section('js-down')
    <script>
        const filter_theme = {!! json_encode($filter_theme, JSON_HEX_TAG) !!};
        localStorage.setItem('filter_theme', filter_theme);
    </script>
    {!! HTML::script('js/questionList.js') !!}

    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
@stop