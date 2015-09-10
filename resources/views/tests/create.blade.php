<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/test_style.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::style('css/createTest.css') !!}
    {!! HTML::script('js/jquery.js') !!}
</head>
<body>
<section>
    <div class="section-body">
        <div class="col-md-12 col-sm-6 card style-primary">
            <h1 class="text-default-bright">Создать тест</h1>
        </div>

        <!-- модуль задания основных настроек теста -->
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
            <h2 class="text-default-bright">Настройка теста</h2>
        </div>
        <form action="{{URL::route('question_add')}}" method="POST" class="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-lg-offset-1 col-md-10 col-sm-6">
                <div class="card">
                    <div class="card-body">
                            <!-- название теста -->
                            <div class="form-group floating-label">
                                <textarea  name="test-name" class="form-control textarea1" rows="1" placeholder=""></textarea>
                                <label for="textarea1">Название теста</label>
                            </div>
                            <!-- тренировочный тест -->
                            <div class="checkbox checkbox-styled">
                                <label>
                                    <input type="checkbox" name="training">
                                    <span>Тренировочный тест</span>
                                </label>
                            </div>
                        <!-- Максимум баллов за тест -->
                        <div class="form-group floating-label">
                            <input type="number" min="1" name="total" id="total" class="form-control">
                            <label for="total">Максимум баллов за тест</label>
                        </div>
                     </div>
                </div>
            </div>
            <div class="col-lg-offset-1 col-md-5 col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <!-- дата открытия теста -->
                            <label>
                                <input type="date" name="start-date" value="2015-09-01">
                                <span>&nbsp Дата открытия теста</span>
                            </label>
                    </div>
                    <div class="card-body">
                        <!-- дата закрытия теста -->
                        <label>
                            <input type="date" name="end-date" value="2016-08-01">
                            <span>&nbsp Дата закрытия теста</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-1">
                <div class="card">
                    <div class="card-body">
                        <!-- время открытия теста -->
                        <label>
                            <input type="time" name="start-time" value="00:00">
                            <span>&nbsp Время открытия теста</span>
                        </label>
                    </div>
                    <div class="card-body">
                        <!-- время закрытия теста -->
                        <label>
                            <input type="time" name="end-time" value="00:00">
                            <span>&nbsp Время закрытия теста</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- модуль создания структуры теста -->
            <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
                <h2 class="text-default-bright">Состав теста</h2>
            </div>
            <div class="col-lg-offset-1 col-md-10 col-sm-1">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped no-margin table-bordered" id="question-table">
                            <thead>
                            <tr>
                                <th class="num-field">Количество вопросов</th>
                                <th class="select-field">Раздел</th>
                                <th class="select-field">Тема</th>
                                <th class="select-field">Тип</th>
                                <th class="num-field">Баллов от</th>
                                <th class="num-field">Баллов до</th>
                            </tr>
                            </thead>
                            <tbody id="row">
                            <tr>
                                <td><input type="number" min="1" name="total[]" id="total" size="1" class="form-control"></td>
                                <td> <select name="section[]" id="select-section" class="form-control select-section" size="1">
                                        <option value="$nbsp"></option>
                                        @foreach ($sections as $section)
                                        <option value="{{$section}}">{{$section}}</option>/td>
                                        @endforeach
                                        <option value="Любой">Любой</option>
                                    </select></td>
                                <td>
                                        <div class="form-group cont" id="container">
                                            <select name="theme[]" id="select-theme" class="form-control" size="1">

                                        <!-- контейнер для ajax -->
                                        </div>
                                </td>
                                <td> <select name="type[]" id="select-type" class="form-control" size="1">
                                        <option value="$nbsp"></option>
                                        @foreach ($types as $type)
                                        <option value="{{$type}}">{{$type}}</option>/td>
                                        @endforeach
                                        <option value="Любой">Любой</option>
                                    </select></td>
                                <td><input type="number" min="1" name="points-from[]" id="points-from" size="1" class="form-control"></td>
                                <td><input type="number" min="1" name="points-till[]" id="points-till" size="1" class="form-control"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-offset-10 col-md-2 col-sm-6" id="add-del-buttons">
                <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-row"><b>+</b>   </button>
                <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-row"><b>-</b></button>
            </div>
            {!! HTML::script('js/testCreate.js') !!}
            {!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
            {!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
            {!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
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
            {!! HTML::script('js/core/source/AppVendor.js') !!}
            {!! HTML::script('js/core/demo/Demo.js') !!}

