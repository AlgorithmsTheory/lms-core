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

                            <div class="form-group">
                                <textarea  name="title" id="textarea1" class="form-control" rows="3" placeholder="Введине название или неполную формулировку теоремы" required>{{ $data['question']['title'] }}</textarea>
                                <label for="textarea1">Текст</label>
                            </div>
                            <div class="form-group">
                                <textarea  name="eng-title" id="textarea1" class="form-control" rows="3" placeholder="Type the name or incomplete formulation of the theorem">{{ $data['question']['title_eng'] }}</textarea>
                                <label for="textarea1">Text</label>
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

                                <button class="btn btn-primary btn-raised submit-question" type="submit">Применить изменения</button>
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
                <button class="btn btn-primary btn-raised submit-question" type="submit">Применить изменения</button>
            </div>
        </div>
    </div>

@stop
@section('js-down')
    {!! HTML::script('js/question_create/accordanceTable.js') !!}
    {!! HTML::script('js/question_create/accordanceTableEng.js') !!}
    {!! HTML::script('js/question_create/questionCreate.js') !!}
@stop