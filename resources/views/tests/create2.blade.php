@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Создание теста - шаг 2</title>
{!! HTML::style('css/createTest2.css') !!}
{!! HTML::style('css/loading_blur.css') !!}
@stop

@section('content')
<div class="section-body" id="page">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Создание теста - шаг 2</h1>
    </div>
    <form action="{{URL::route('test_add')}}" method="POST" class="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="num-rows" name="num-rows" value="1">
        <input type="hidden" id="sections-info" name="sections-info" value="{{$json_sections}}">
        <input type="hidden" id="types-info" name="types-info" value="{{$json_types}}">

        <div id="structures">

            <!-- структурный блок -->
            <div class="col-md-12 structure" id="structure-1">
                <div class="card card-bordered style-primary card-collapsed">
                    <div class="card-head">
                        <header>
                            Структура №1
                        </header>
                    </div>
                    <div class="card-body style-default-bright">
                        <div class="form-group dropdown-label col-md-4 col-sm-4">
                            <input type="number" min="1" step="1" name="number_of_questions[]" class="form-control number_of_questions" required>
                            <label for="number_of_questions-1">Число вопросов</label>
                        </div>
                        <div class="form-group dropdown-label col-md-4 col-sm-4">
                            <input type="number" min="1" step="1" name="number_of_access_questions[]" class="form-control number_of_access_questions" disabled>
                            <label for="number_of_access_questions-1">Доступно вопросов данной структуры</label>
                        </div>

                        <div class="sections_and_themes">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th width="50%" class="text-lg">Выберите разделы:</th>
                                        <th width="50%" class="text-lg">Выберите темы:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=0; $i < count($sections); $i++)
                                        <tr class="section-tr" id="section-tr-{{ $i }}">
                                            <td rowspan="1" class="section-td">
                                                <div class="checkbox checkbox-styled checkbox-section">
                                                    <label>
                                                        <input type="checkbox" name="sections[0][]" value="{{ $sections[$i]['code'] }}">  <!-- номер структуры -->
                                                        <span>{{ $sections[$i]['name'] }}</span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td style="display: none" class="theme-td">
                                                <div class="checkbox checkbox-styled checkbox-fst-theme">
                                                    <label>
                                                        <input type="checkbox" name="themes[0][{{ $i }}][]" value="{{ $sections[$i]['themes'][0]['theme_code'] }}">   <!-- номер структуры, номер секции в структуре -->
                                                        <span>{{ $sections[$i]['themes'][0]['theme_name'] }}</span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        @for($j = 1; $j < count($sections[$i]['themes']); $j++)
                                            <tr class="theme-tr-{{ $i }}" style="display: none">
                                                <td></td>
                                                <td class="theme-td">
                                                    <div class="checkbox checkbox-styled checkbox-theme">
                                                        <label>
                                                            <input type="checkbox" name="themes[0][{{ $i }}][]" value="{{ $sections[$i]['themes'][$j]['theme_code'] }}">
                                                            <span>{{ $sections[$i]['themes'][$j]['theme_name'] }}</span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="types">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th class="text-lg">Выберите типы:</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < count($types); $i += 4)
                                        <tr>
                                            <td class="type-td">
                                                @if($i < count($types))
                                                    <div class="checkbox checkbox-styled checkbox-type">
                                                        <label>
                                                            <input type="checkbox" name="types[0][]" value="{{ $types[$i]['type_code'] }}">
                                                            <span>{{ $types[$i]['type_name'] }}</span>
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="type-td">
                                                @if($i + 1 < count($types))
                                                    <div class="checkbox checkbox-styled checkbox-type">
                                                        <label>
                                                            <input type="checkbox" name="types[0][]" value="{{ $types[$i + 1]['type_code'] }}">
                                                            <span>{{ $types[$i + 1]['type_name'] }}</span>
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="type-td">
                                                @if($i + 2 < count($types))
                                                    <div class="checkbox checkbox-styled checkbox-type">
                                                        <label>
                                                            <input type="checkbox" name="types[0][]" value="{{ $types[$i + 2]['type_code'] }}">
                                                            <span>{{ $types[$i + 2]['type_name'] }}</span>
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="type-td">
                                                @if($i + 3 < count($types))
                                                    <div class="checkbox checkbox-styled checkbox-type">
                                                        <label>
                                                            <input type="checkbox" name="types[0][]" value="{{ $types[$i + 3]['type_code'] }}">
                                                            <span>{{ $types[$i + 3]['type_name'] }}</span>
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-offset-10 col-md-2 col-sm-6" id="add-del-buttons">
            <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-structure"><b>+</b>   </button>
            <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-structure"><b>-</b></button>
        </div>
        <div class="col-lg-offset-1 col-md-2 col-sm-6" id="add-test">
            <button class="btn btn-primary btn-raised submit-test" type="submit">Добавить тест</button>
            <br><br>
        </div>
    </form>
</div>
<div id="overlay" class="none">
    <div class="loading-pulse"></div>
</div>
@stop

@section('js-down')
{!! HTML::script('js/testCreate2.js') !!}
@stop


