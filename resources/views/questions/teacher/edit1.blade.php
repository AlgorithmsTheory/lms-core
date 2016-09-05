@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Редактирование вопроса</title>
{!! HTML::style('css/question_create.css') !!}
@stop

@section('content')
<div class="section-body" id="page">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Редактировать вопрос</h1>
    </div>
    <form action="{{URL::route('question_update', array($id_question))}}" method="POST" class="form" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="q-type" value="">
        <div class="col-lg-offset-1 col-md-10 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <!-- Выбор типа вопроса -->
                    <div class="form-group ">
                        <select name="type" id="select-type" class="form-control" size="1" disabled>
                            <option value="{{ $type }}"></option>
                        </select>
                        <label for="select-type">Тип</label>
                    </div>
                    <div id="type_question_add">
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="control" id="control">
                                <span>Только для контрольных тестов</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <textarea  name="title" id="textarea1" class="form-control" rows="3" placeholder="" required></textarea>
                            <label for="textarea1">Текст</label>
                        </div>
                        <div id="text-images-container">
                            <input type="file" name="text-images[]" id="text-image-input-1" class="text-image-input">
                        </div>
                        <br>

                        <div id="variants" class="col-md-10 col-sm-6">
                            <div class="form-group">
                                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="Этот вариант будет ответом" required></textarea>
                                <label for="textarea3">Вариант 1</label>
                            </div>
                            <div class="form-group">
                                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>
                                <label for="textarea3">Вариант 2</label>
                            </div>
                            <div class="form-group">
                                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>
                                <label for="textarea3">Вариант 3</label>
                            </div>
                            <div class="form-group">
                                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>
                                <label for="textarea3">Вариант 4</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6" style="margin-top: 220px" id="add-del-buttons">
                            <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-var-1"><b>+</b>   </button>
                            <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-var-1"><b>-</b></button>
                        </div>

                        <div id="other-options" class="col-md-10 col-sm-6">
                            <div class="form-group">
                                <select name="section" id="select-section" class="form-control" size="1">
                                    <option value="$nbsp"></option>
                                    @foreach ($sections as $section)
                                    <option value="{{$section['section_name']}}">{{$section['section_name']}}</option>/td>
                                    @endforeach
                                </select>
                                <label for="select-section">Раздел</label>
                            </div>

                            <div class="form-group" id="container">
                                <!-- контейнер для ajax -->
                            </div>

                            <div class="form-group">
                                <input type="number" min="1" name="points" id="points" class="form-control" value="1">
                                <label for="points">Баллы за верный ответ</label>
                            </div>

                            <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить вопрос</button>
                            <a id="preview-btn" class="btn btn-primary btn-raised" href="#question-preview">Preview</a>
                        </div>
                    </div>  <!-- Закрываем card-body -->
                </div>  <!-- Закрываем card -->
            </div>  <!-- Закрываем col-md -->
        </div>
    </form>
    <div id="question-preview" class="modalDialog">
        <div>
            <a id="close-btn" class="btn ink-reaction btn-floating-action btn-danger close" href="#close" title="Close">X</a>
            <h2>Предварительный просмотр</h2>
            <form class="smart-blue">
                <h1>Вопрос 1</h1>
                <h2 id="preview-text"></h2>
                <div id="preview-container"></div>
            </form>
            <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить вопрос</button>
        </div>
    </div>
</div>

    @stop
    @section('js-down')
    {!! HTML::script('js/question_create/oneChoice.js') !!}
    {!! HTML::script('js/question_create/imageInTitle.js') !!}
    {!! HTML::script('js/question_create/questionCreate.js') !!}
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
    @stop