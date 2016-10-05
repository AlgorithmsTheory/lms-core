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

        <input type="hidden" id="js_word_number" value="{{ $data['js_word_number'] }}">
        <input type="hidden" id="js_word_number_eng" value="{{ $data['eng_js_word_number'] }}">
        <input type="hidden" id="js_span_last" value="{{ $data['js_span_last'] }}">
        <input type="hidden" id="js_span_last_eng" value="{{ $data['eng_js_span_last'] }}">
        <input type="hidden" id="js_span_edge" value="{{ $data['js_span_edge'] }}">
        <input type="hidden" id="js_span_edge_eng" value="{{ $data['eng_js_span_edge'] }}">
        @for ($i = 1; $i <= count($data['variants']); $i++)
            <input type="hidden" id="js_count_{{ $i }}" value="{{ count($data['variants'][$i-1])}}">
        @endfor
        @for ($j = $i; $j <= 50; $j++)
            <input type="hidden" id="js_count_{{ $j }}" value="5">
        @endfor
        @for ($i = 1; $i <= count($data['eng_variants']); $i++)
        <input type="hidden" id="js_count_eng_{{ $i }}" value="{{ count($data['eng_variants'][$i-1])}}">
        @endfor
        @for ($j = $i; $j <= 50; $j++)
        <input type="hidden" id="js_count_eng_{{ $j }}" value="5">
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
                        <!-- На русском языке -->
                        <div class="style-gray card">
                            <div class="card-body text-default-bright text-center text-lg">
                                Русский язык
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="title" id="edit-text" value="{{ $data['clear_text'] }}" rows="3" style="display: none;" placeholder="Введите текст вопроса, нажмите кнопку завершения редактирования, затем выделите пропущенные слова">
                                {{ $data['clear_text'] }}
                            </textarea>
                            <p class="lead" id="general-text" style="display:block;">
                                {!! $data['text'] !!}
                            </p>
                            <label for="textarea1">Текст</label>
                            <input type="hidden" value="">
                        </div>
                        <button class="btn btn-primary btn-raised" type="button" value="finish" id="edit"><span id="button-title">Вернуться к редактированию</span></button>
                        <button class="btn btn-primary btn-raised" type="button" id="union">Перейти в режим объединения слов</button>
                        <button class="btn btn-primary btn-raised" type="button" id="cancel-selection" style="display:none">Сбросить выделение</button>
                        <div id="word-variants">
                            @for ($i = 0; $i < count($data['variants']); $i++)
                                <div class="card-body span-{{ $data['variants'][$i]['span'] }}" id="card-body-{{ $i+1 }}">
                                    <div class="col-md-12 col-sm-6 var-column" id="column-{{ $i+1 }}">
                                        <div class="form-group">
                                            <textarea  name="variants-{{ $i+1 }}[]"  class="form-control textarea3" rows="1" value="{{ $data['costs'][$i] }}" required>{{ $data['costs'][$i] }}</textarea>
                                            <label for="textarea3">Стоимость</label>
                                        </div>
                                        @for ($j = 0; $j < count($data['variants'][$i]) - 1; $j++)
                                            <div class="form-group">
                                                @if ($j == 0)
                                                    <textarea  name="variants-{{ $i+1 }}[]"  class="form-control textarea3 text-answer" rows="1" value="{{ $data['variants'][$i][$j] }}">{{ $data['variants'][$i][$j] }}</textarea>
                                                @else
                                                <textarea  name="variants-{{ $i+1 }}[]"  class="form-control textarea3" rows="1" value="{{ $data['variants'][$i][$j] }}">{{ $data['variants'][$i][$j] }}</textarea>
                                                @endif
                                                <label for="textarea3">Вариант {{ $j+1 }}</label>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="col-md-offset-10 col-md-6 col-sm-6" id="add-del-buttons-{{ $i+1 }}">
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-success add-var-3" id="var-add-button-{{ $i+1 }}"><b>+</b>   </button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-danger del-var-3" id="var-del-button-{{ $i+1 }}"><b>-</b></button>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <br><br>

                        <!-- На английском языке -->
                        <div class="style-gray card">
                            <div class="card-body text-default-bright text-center text-lg">
                                Английский язык
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="eng-title" id="eng-edit-text" value="{{ $data['eng_clear_text'] }}" rows="3" style="display: none;" placeholder="Type question's title, press button to finish editing, then select missed words">
                                {{ $data['clear_text'] }}
                            </textarea>
                            <p class="lead" id="eng-general-text" style="display:block;">
                                {!! $data['eng_text'] !!}
                            </p>
                            <label for="textarea1">Text</label>
                            <input type="hidden" value="">
                        </div>
                        <button class="btn btn-primary btn-raised" type="button" value="finish" id="eng-edit"><span id="eng-button-title">Finish editing text</span></button>
                        <button class="btn btn-primary btn-raised" type="button" id="eng-union">Go to union mode</button>
                        <button class="btn btn-primary btn-raised" type="button" id="eng-cancel-selection" style="display:none">Reset selection</button>
                        <div id="eng-word-variants">
                            @for ($i = 0; $i < count($data['eng_variants']); $i++)
                            <div class="eng-card-body eng-span-{{ $data['eng_variants'][$i]['span'] }}" id="eng-card-body-{{ $i+1 }}">
                                <div class="col-md-12 col-sm-6 var-column" id="eng-column-{{ $i+1 }}">
                                    <div class="form-group">
                                        <textarea  name="eng-variants-{{ $i+1 }}[]"  class="form-control textarea3" rows="1" value="{{ $data['eng_costs'][$i] }}" required>{{ $data['eng_costs'][$i] }}</textarea>
                                        <label for="textarea3">Cost</label>
                                    </div>
                                    @for ($j = 0; $j < count($data['eng_variants'][$i]) - 1; $j++)
                                    <div class="form-group">
                                        @if ($j == 0)
                                        <textarea  name="eng-variants-{{ $i+1 }}[]"  class="form-control textarea3 text-answer" rows="1" value="{{ $data['eng_variants'][$i][$j] }}">{{ $data['eng_variants'][$i][$j] }}</textarea>
                                        @else
                                        <textarea  name="eng-variants-{{ $i+1 }}[]"  class="form-control textarea3" rows="1" value="{{ $data['eng_variants'][$i][$j] }}">{{ $data['eng_variants'][$i][$j] }}</textarea>
                                        @endif
                                        <label for="textarea3">Variant {{ $j+1 }}</label>
                                    </div>
                                    @endfor
                                </div>
                                <div class="col-md-offset-10 col-md-6 col-sm-6" id="eng-add-del-buttons-{{ $i+1 }}">
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-success eng-add-var-3" id="eng-var-add-button-{{ $i+1 }}"><b>+</b></button>
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-danger eng-del-var-3" id="eng-var-del-button-{{ $i+1 }}"><b>-</b></button>
                                </div>
                            </div>
                            @endfor
                        </div>

                        <br><br>
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
        <input type="hidden" id="number-of-blocks" value="" name="number_of_blocks">
        <input type="hidden" id="eng-number-of-blocks" value="" name="eng_number_of_blocks">
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
{!! HTML::script('js/question_create/fillGaps.js') !!}
{!! HTML::script('js/question_create/fillGapsEng.js') !!}
@stop