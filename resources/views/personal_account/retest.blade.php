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
<div class="col-lg-offset-1 col-md-10 col-sm-6">
    <div class="card">
        <div class="card-body">
            <nav class="navbar col-md-4 col-md-offset-4 style-primary">
                <h3 class="text-center">Переписывание тестов</h3>
            </nav>
            <br>
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
                        @for ($i=0; $i < count($all_tests); $i++)
                            <option value="{{ $all_tests[$i] }}">{{ $all_tests[$i] }}</option>
                        @endfor
                    </select>
                    <label for="selected-test">Тесты</label>
                </div>
                <div class="form-group col-md-6">
                    <select name="type" id="selected-group" class="form-control" size="1">
                        <option value="">Все</option>
                        @foreach ($distinct_groups as $group)
                            <option value="{{ $group['group'] }}">{{ $group['group'] }}</option>
                        @endforeach
                    </select>
                    <label for="selected-group">Группа</label>
                </div>
                <div class="form-group col-md-6">
                    <select name="type" id="selected-student" class="form-control" size="1">
                        <option value="">Все</option>
                        @foreach ($users as $user)
                        <option value="{{ $user['last_name'] }} {{ $user['first_name'] }}">{{ $user['last_name'] }} {{$user['first_name'] }}</option>
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
                @for ($i=0; $i < count($accesses); $i++)
                <input type="hidden" name="id[]" value="{{$id[$i]}}">
                <tr style="display:;">
                    <td >{{ $student_names[$i] }}</td>
                    <td class="text-center">{{ $groups[$i] }}</td>
                    <td class="text-center">{{ $test_names[$i] }}</td>
                    <td class="text-center">{{ $attempts[$i] }}</td>
                    <td class="text-center last-marks">{{ $last_marks[$i] }}</td>
                    <td class="text-center">
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" class="flag"  @if ($accesses[$i] == 1) checked @endif>
                                <input class="support-checkbox" name="fines[]" type="hidden" @if ($accesses[$i] == 1) value="1"
                                @else value="0"
                                @endif
                                >
                                <span></span>
                            </label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-group">
                            <input type="number" min="70" max="100" step="5" name="fine-levels[]" class="form-control fine-level" value="{{$fines[$i]}}">
                        </div>
                    </td>
                </tr>
                @endfor
                </tbody>
            </table>
            <div class="col-lg-offset-9"  id="change">
                <button class="btn btn-primary btn-raised submit-test" type="submit">Применить изменения</button>
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
{!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}

@stop
