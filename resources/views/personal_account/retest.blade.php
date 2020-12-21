@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Переписывание тестов</title>
{!! HTML::style('css/bootstrap.css') !!}
{!! HTML::style('css/materialadmin.css') !!}
{!! HTML::style('css/full.css') !!}
@stop

@section('background')
full
@stop

@section('content')
<div class="col-md-12 col-sm-6 card style-primary text-center">
    <h1 class="">Переписывание тестов</h1>
</div>
<div class="col-lg-offset-1 col-md-10 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12">
                <a class="btn btn-raised ink-reaction btn-default-bright pull-right" href="#offcanvas-demo-right" data-toggle="offcanvas">
                    <i class="md md-help"></i>
                </a>
            </div>
            <br>
            <br>
            <form action="{{URL::route('retest_change')}}" method="POST" id="retest-form" class="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form">
                <div class="form-group col-md-6">
                    <select name="type" id="selected-test" class="form-control" size="1">
                        <option value="">Все</option>
                        @foreach ($tests as $test)
                            <option value="{{ $test->test_name }}">{{ $test->test_name }}</option>
                        @endforeach
                    </select>
                    <label for="selected-test">Тесты</label>
                </div>
                <div class="form-group col-md-6">
                    <select name="type" id="selected-group" class="form-control" size="1">
                        <option value="">Все</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->group_name }}">{{ $group->group_name }}</option>
                        @endforeach
                    </select>
                    <label for="selected-group">Группа</label>
                </div>
                <div class="form-group col-md-6">
                    <select name="type" id="selected-student" class="form-control" size="1">
                        <option value="">Все</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->user_name }}">{{ $user->user_name }}</option>
                        @endforeach
                    </select>
                    <label for="selected-student">Студент</label>
                </div>
                <div class="form-group col-md-6">
                    <select name="type" id="selected-mark" class="form-control" size="1">
                        <option value="All">Все</option>
                        @foreach ($marks as $mark)
                        <option value="{{ $mark }}">{{ $mark }}</option>
                        @endforeach
                    </select>
                    <label for="selected-mark">Оценка</label>
                </div>
            </div>
            <br>
            <br>
            <table class="table table-condensed" id="retest-table">
                <tr>
                    <td>ФИО</td>
                    <td>Группа</td>
                    <td>Название теста</td>
                    <td>Число попыток</td>
                    <td>Последняя оценка</td>
                    <td>Возможность прохождения</td>
                    <td>Максимальный балл, %</td>
                </tr>
                <tbody id="target">
                @foreach ($fines as $fine)
                <input type="hidden" name="id[]" value="{{ $fine['id'] }}">
                <tr class="fine-row">
                    <td class="text-center students">{{ $fine['student'] }}</td>
                    <td class="text-center groups">{{ $fine['group'] }}</td>
                    <td class="text-center tests">{{ $fine['test'] }}</td>
                    <td class="text-center">{{ $fine['attempts'] }}</td>
                    <td class="text-center last-marks">{{ $fine['last_mark'] }}</td>
                    <td class="text-center">
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" class="flag"  @if ($fine['access'] == 1) checked @endif>
                                <input class="support-checkbox" name="fns[]" type="hidden" @if ($fine['access'] == 1) value="1"
                                @else value="0"
                                @endif
                                >
                                <span></span>
                            </label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-group">
                            <input type="number" min="70" max="100" step="5" name="fine-levels[]" class="form-control fine-level" value="{{$fine['fine']}}">
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-lg-offset-9"  id="change"  style="display: none">
                <button id="send_button" class="btn btn-primary btn-raised submit-test" type="submit">Кнопка отправки формы</button>
            </div>
            <div class="col-lg-offset-9"  id="change">
                <button id="set_button" class="btn btn-primary btn-raised">Применить изменения</button>
            </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('right-off-canvas')
    <div id="offcanvas-demo-right" class="offcanvas-pane width-12">
        <div class="offcanvas-head">
            <header class="text-center">Модуль переписывания</header>
            <div class="offcanvas-tools">
                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                    <i class="md md-close"></i>
                </a>
            </div>
        </div>
        <div class="nano has-scrollbar" style="height: 600px;"><div class="nano-content" tabindex="0" style="right: -17px;"><div class="offcanvas-body">


                    <ul class="list-divided">
                        <li>Наличие галочки в колонке "возможность прохождения" обозначает, что данному студенту доступен заданный тест при условии, что он открыт.</li>
                        <li>Вместе с оценкой "F" показываются и студенты, отсутствующие при последнем прохождении данного теста.</li>
                        <li>Штраф - это нормирующий множитель для оценки результата следующего прохождения заданного теста данным студентом.</li>
                        <li>Штраф выбирается из множества {100, 90, 85, 80, 75, 70}. При вводе отличного значения, будет выведено сообщение об ошибке.</li>
                    </ul>
                </div></div><div class="nano-pane"><div class="nano-slider" style="height: 199px; transform: translate(0px, 0px);"></div></div></div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/retest.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
@stop
