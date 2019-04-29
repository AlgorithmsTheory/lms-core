@extends('templates.base')
@section('head')
    <title>Ведомости</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::script('js/jquery.js') !!}
    {!! HTML::style('css/loading_blur.css') !!}
    <meta name="csrf_token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div id="main_container">
        <div class="card col-lg-12 col-md-12">
            <div class="card-body">
                <h2 class="text-center">Просмотр и редактирование веломостей</h2>
                <form action="" method="" class="form" id="forma">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    @if($user['role'] == 'Админ')
                    <div class="form-group">
                        {{--<textarea  class="form-control textarea3" id="group_num" rows="1" placeholder="Номер группы" required></textarea>--}}
                        {{--<label for="textarea3">Напишите номер группы</label>--}}

                        <select name="group" id="group_num" class="form-control textarea3" size="1" required>
                            @foreach($group_set as $g)
                                <option value="{{ $g['group_id'] }}">{{ $g['group_name'] }}</option>/td>
                            @endforeach
                        </select>
                        <label for="group_num">Выберите группу</label>

                    </div>
                    @else

                    <div class="form-group">
                        <select name="type" id="group_num" class="form-control" size="1" required>
                            {{--<option value="">Все</option>--}}
                            @foreach($groups as $group)
                                <option value="{{ $group['group_id'] }}">{{ $group['group_name'] }}</option>
                            @endforeach
                        </select>
                        <label for="select-type">Выбор группы</label>
                    </div>
                    @endif

                    <div class="form-group">
                        <select name="type" id="select-type" class="form-control" size="1">
                            <option value="lectures">Посещение лекций</option>
                            <option value="seminars">Работа на семинарах</option>
                            <option value="resulting">Итоги</option>

                        </select>
                        <label for="select-type">Тип ведомости</label>
                    </div>
                    <button class="btn btn-primary btn-raised submit-question" id="show">Показать</button>
                </form>
                <br>
                <br>
                <div id="statement" class="table-responsive">
                </div>
            </div>
        </div>

    </div>
    <div id="overlay" class="none">
        <div class="loading-pulse"></div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/statements/statements.js') !!}
@stop
