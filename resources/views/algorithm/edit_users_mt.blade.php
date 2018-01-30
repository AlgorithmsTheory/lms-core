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
    <h1 class="">Переписывание контрольных работ по теме "Машина Тьюринга"</h1>
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
            <form action="{{URL::route('edit_users_mt_change')}}" method="POST" id="retest-form" class="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form">
                
            </div>
            <br>
            <input type="text" id="myInput0" onkeyup="myFunction(0)" placeholder="Поиск по фамилии" style="margin-right: 25px;">
            <input type="text" id="myInput2" onkeyup="myFunction(2)" placeholder="Поиск по группе">
            <br> 
            <table class="table table-condensed" id="retest-table" style="margin-top: 25px;">
                <tr>
                    <th id="0" name="th">Фамилия</th>
                    <th id="1" name="th">Имя</th>
                    <th id="2" name="th" class="text-center">Группа</th>
                    <!-- <td>Название теста</td> -->
                    <!-- <td>Число попыток</td> -->
                    <th id="3" name="th" class="text-center">Последняя оценка</th>
                    <th id="4" name="th" class="text-center">Возможность прохождения</th>
                   <!--  <td>Максимальный балл, %</td> -->
                </tr>
                <tbody id="target">
                @for ($i=0; $i < count($all_users); $i++)
                <input type="hidden" name="id[]" value="{{$all_users[$i]['id']}}">
                <tr>
                    <td >{{ $all_users[$i]['last_name'] }}</td>
                    <td >{{ $all_users[$i]['first_name'] }}</td>
                    <td class="text-center">{{ $all_users[$i]['group_name'] }}</td>
                    <!-- <td class="text-center">{{ $test_names[$i] }}</td> -->
                  <!--   <td class="text-center">{{ $attempts[$i] }}</td> -->
                    <td class="text-center last-marks"> {{ $all_users[$i]['sum_mark'] }}</td>
                    <td class="text-center">
                        <div class="checkbox checkbox-styled">
                            <label>
                               <!--  <input type="checkbox" class="flag"  @if ($all_users[$i]['access'] == 1) checked @endif> -->
                                <input type="checkbox" class="checkbox" name="fines[]"   value="{{$all_users[$i]['id']}}" 
                                @if ($all_users[$i]['access'] == 1)
                                checked
                                @endif
                                >
                                <span></span>
                            </label>
                        </div>
                    </td>
<!--                     <td class="text-center">
                        <div class="form-group">
                            <input type="number" min="70" max="100" step="5" name="fine-levels[]" class="form-control fine-level" value="{{$fines[$i]}}">
                        </div>
                    </td> -->
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
                        <li>Наличие галочки в колонке "Возможность прохождения" обозначает, что данному студенту доступен контрольный режим эмулятора.</li>
                        <li>Вместе с оценкой 0 показываются и студенты, отсутствующие на контрольном мероприятии.</li>
                        <!-- <li>Штраф - это нормирующий множитель для оценки результата следующего прохождения заданного теста данным студентом.</li>
                        <li>Штраф выбирается из множества {100, 90, 85, 80, 75, 70}. При вводе отличного значения, будет выведено сообщение об ошибке.</li> -->
                    </ul>
                </div></div><div class="nano-pane"><div class="nano-slider" style="height: 199px; transform: translate(0px, 0px);"></div></div></div>
    </div>
@stop

@section('js-down')
{!! HTML::script('js/retest.js') !!}

{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
{!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
{!! HTML::script('js/algorithms/sort.js') !!}
@stop
