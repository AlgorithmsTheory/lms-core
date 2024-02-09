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
            <input type="hidden" id="table-tr" value="{{ count($data['title']) }}">
            <input type="hidden" id="table-td" value="{{ count($data['variants']) }}">
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

                            <table id="myTable" class="table table-bordered">
                                <tbody id="myBody">
                                    <tr id="0">
                                        <td>#</td>
                                        @foreach($data['variants'] as $col)
                                            <td>
                                                <input type="text" style="width: 80px;" placeholder="Свойство" name="variants[]" value="{{ $col }}">
                                            </td>
                                        @endforeach
                                    </tr>
                                    <?php $row_counter = 1; ?>
                                    @foreach($data['title'] as $row)
                                        <tr id="{{ $row_counter }}">
                                            <td>
                                                <textarea placeholder="Объект" name="title[]">{{ $row }}</textarea>
                                            </td>
                                            <?php $col_counter = 1; ?>
                                            @foreach($data['variants'] as $col)
                                                <?php $value = ($row_counter - 1) * count($data['variants']) + $col_counter; ?>
                                                <td>
                                                    <div class="checkbox checkbox-styled">
                                                        <label>
                                                            <input type="checkbox" name="answer[]"
                                                                   value="{{ $value }}"
                                                                   @if(in_array($value, $data['answers']))
                                                                       checked
                                                                   @endif
                                                            >
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <?php $col_counter++; ?>
                                            @endforeach
                                        </tr>
                                        <?php $row_counter++; ?>
                                    @endforeach
                                </tbody>
                            </table>

                            <br><br>

                            <table id="table-eng" class="table table-bordered">
                                <tbody id="body-eng">
                                <tr id="0">
                                    <td>#</td>
                                    @foreach($data['eng_variants'] as $col)
                                        <td>
                                            <input type="text" style="width: 80px;" placeholder="Property" name="eng-variants[]" value="{{ $col }}">
                                        </td>
                                    @endforeach
                                </tr>
                                <?php $row_counter = 1; ?>
                                @foreach($data['eng_title'] as $row)
                                    <tr id="{{ $row_counter }}">
                                        <td>
                                            <textarea placeholder="Object" name="eng-title[]">{{ $row }}</textarea>
                                        </td>
                                        <?php $col_counter = 1; ?>
                                        @foreach($data['eng_variants'] as $col)
                                            <?php $value = ($row_counter - 1) * count($data['eng_variants']) + $col_counter; ?>
                                            <td>
                                                <div class="checkbox checkbox-styled">
                                                    <label>
                                                        <input type="checkbox" name="eng-answer[]"
                                                               value="{{ $value }}"
                                                               @if(in_array($value, $data['eng_answers']))
                                                               checked
                                                                @endif
                                                        >
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <?php $col_counter++; ?>
                                        @endforeach
                                    </tr>
                                    <?php $row_counter++; ?>
                                @endforeach
                                </tbody>
                            </table>

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

                                <!-- Баллы за правильный ответ -->
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

@stop
@section('js-down')
    {!! HTML::script('js/question_create/accordanceTable.js') !!}
    {!! HTML::script('js/question_create/accordanceTableEng.js') !!}
    {!! HTML::script('js/question_create/questionCreate.js') !!}
@stop