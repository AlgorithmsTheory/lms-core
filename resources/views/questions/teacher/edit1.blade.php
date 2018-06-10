@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Редактирование вопроса</title>
{!! HTML::style('css/question_create.css') !!}
{!! HTML::style('css/loading_blur.css') !!}
@stop

@section('content')
<div class="section-body" id="page">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Редактировать вопрос</h1>
    </div>
    <form action="{{URL::route('question_update')}}" method="POST" class="form" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id-question" value="{{ $data['question']['id_question'] }}">
        <input type="hidden" name="type" value="{{ $data['type_name'] }}">
        <input type="hidden" id="count" value="{{ $data['count'] }}">
        @for ($i = 1; $i < count($data['images']); $i += 2)
            <input type="hidden" class="images-in-text" value="{{ $data['images'][$i] }}">
        @endfor

        <div class="col-lg-offset-1 col-md-10 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <!-- Выбор типа вопроса -->
                    <div class="form-group ">
                        <select name="type" id="select-type" class="form-control" size="1" disabled>
                            <option value="{{ $data['type_name'] }}">{{ $data['type_name'] }}</option>
                        </select>
                        <label for="select-type">Тип</label>
                    </div>
                    <div id="type_question_add">
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="control" id="control"
                                @if ($data['question']['control'] == 1)
                                    checked
                                @endif
                                >
                                <span>Только для контрольных тестов</span>
                            </label>
                        </div>
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="translated" id="translated"
                                @if ($data['question']['translated'] == 1)
                                    checked
                                @endif
                                >
                                <span>Переведен на английский язык</span>
                            </label>
                        </div>

                        <!-- Текст на русском языке -->
                        <div class="form-group">
                            <textarea  name="title" id="textarea1" class="form-control" rows="3" placeholder="" required>{{ $data['question']['title'] }}</textarea>
                            <label for="textarea1">Текст</label>
                        </div>

                        <!-- Текст на английском языке -->
                        <div class="form-group">
                            <textarea  name="eng-title" id="eng-textarea1" class="form-control" rows="3" placeholder="">{{ $data['question']['title_eng'] }}</textarea>
                            <label for="textarea1">Text</label>
                        </div>

                        <div id="text-images-container">
                            <input type="file" name="text-images[]" id="text-image-input-1" class="text-image-input">
                        </div>
                        <br>

                        <!-- Русские варианты ответа -->
                        <div id="variants" class="col-md-6 col-sm-6">
                            @for ($i = 0; $i < $data['count']; $i++)
                                <div class="form-group">
                                    <textarea  name="variants[]" class="form-control textarea3" rows="1" required placeholder=""
                                    @if ($i == 0)
                                    placeholder="Этот вариант будет ответом"
                                    @endif
                                    >{{$data['variants'][$i]}}</textarea>
                                    <label for="textarea3">Вариант {{$i+1}}</label>
                                </div>
                            @endfor
                        </div>
                        <!-- Английские варианты ответа -->
                        <div id="eng-variants" class="col-md-6 col-sm-6">
                            @for ($i = 0; $i < $data['count']; $i++)
                                <div class="form-group">
                                    <textarea  name="eng-variants[]"  class="form-control textarea3" rows="1" placeholder=""
                                    @if ($i == 0)
                                    placeholder="This variant will be the answer"
                                    @endif
                                    >{{$data['eng_variants'][$i]}}</textarea>
                                    <label for="textarea3">Variant {{$i+1}}</label>
                                </div>
                            @endfor
                        </div>
                        <div class="col-lg-offset-10 col-md-10 col-sm-6" id="add-del-buttons">
                            <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-var-1"><b>+</b></button>
                            <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-var-1"><b>-</b></button>
                        </div>

                        <div id="other-options" class="col-md-10 col-sm-6">
                            <div class="form-group">
                                <select name="section" id="select-section" class="form-control" size="1" required>
                                    @foreach ($sections as $section)
                                        <option value="{{$section['section_name']}}"
                                        @if ($section['section_code'] == $data['question']['section_code'])
                                        selected
                                        @endif
                                        >{{$section['section_name']}}</option>
                                    @endforeach
                                </select>
                                <label for="select-section">Раздел</label>
                            </div>

                            <div class="form-group" id="container">
                                <select name="theme" id="select-theme" class="form-control" size="1" required>
                                    @foreach ($themes as $theme)
                                        <option value="{{$theme['theme_name']}}"
                                        @if ($theme['theme_code'] == $data['question']['theme_code'])
                                        selected
                                        @endif
                                        >{{$theme['theme_name']}}</option>
                                    @endforeach
                                </select>
                                <label for="select-theme">Тема</label>
                            </div>

                            <div class="form-group">
                                <input type="number" min="1" name="points" id="points" class="form-control" value="{{ $data['question']['points'] }}">
                                <label for="points">Баллы за верный ответ</label>
                            </div>

                            <!-- Сложность -->
                            <div class="form-group col-md-11 col-sm-11">
                                <textarea  name="difficulty" id="difficulty" class="form-control" rows="1" placeholder="" required readonly>{{ $data['question']['difficulty'] }}</textarea>
                                <label for="difficulty">Сложность</label>
                            </div>
                            <div class="col-md-1 col-sm-1">
                                <button class="btn btn-warning btn-raised submit-question" type="button" id="reevaluate-difficulty">Пересчитать</button>
                            </div>

                            <!-- Дискриминант -->
                            <div class="form-group col-md-11 col-sm-11">
                                <textarea  name="discriminant" id="discriminant" class="form-control" rows="1" placeholder="" required readonly>{{ $data['question']['discriminant'] }}</textarea>
                                <label for="discriminant">Дискриминант</label>
                            </div>
                            <div class="col-md-1 col-sm-1">
                                <button class="btn btn-warning btn-raised submit-question" type="button" id="reevaluate-discriminant">Пересчитать</button>
                            </div>

                            <!-- Коэффициент угадывания -->
                            <div class="form-group col-md-12 col-sm-12">
                                <textarea  name="guess" id="guess" class="form-control" rows="1" placeholder="" required readonly>{{ $data['question']['guess'] }}</textarea>
                                <label for="guess">Коэффициент угадывания</label>
                            </div>

                            <!-- Время на вопрос -->
                            <div class="form-group col-md-12 col-sm-12">
                                <input type="number" min="30" step="1" max="3600" name="pass-time" id="pass-time" class="form-control" value="{{ $data['question']['pass_time'] }}">
                                <label for="pass-time">Время на вопрос в секундах</label>
                            </div>

                            <div class="form-group col-md-12 col-sm-12">
                                <button class="btn btn-primary btn-raised submit-question" type="submit">Применить изменения</button>
                                <a id="preview-btn" class="btn btn-primary btn-raised" href="#question-preview">Preview</a>
                            </div>
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
            <button class="btn btn-primary btn-raised submit-question" type="submit">Применить изменения</button>
        </div>
    </div>
</div>
<div id="overlay" class="none">
    <div class="loading-pulse"></div>
</div>

    @stop
    @section('js-down')
    {!! HTML::script('js/question_create/oneChoice.js') !!}
    {!! HTML::script('js/question_create/imageInTitle.js') !!}
    {!! HTML::script('js/question_create/questionCreate.js') !!}
    @stop