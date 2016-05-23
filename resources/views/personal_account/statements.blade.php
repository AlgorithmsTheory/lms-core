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
        <div class="card">
            <div class="card-body">
                <h2 class="text-center">Просмотр и редактирование веломостей</h2>
                <form action="" method="" class="form" id="forma">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    @if($user['role'] == 'Админ')
                    <div class="form-group">
                        <textarea  class="form-control textarea3" id="group_num" rows="1" placeholder="Номер группы" required></textarea>
                        <label for="textarea3">Напишите номер группы</label>
                    </div>
                    @else

                    <div class="form-group">
                        <select name="type" id="group_num" class="form-control" size="1" required>
                            {{--<option value="">Все</option>--}}
                            @foreach($groups as $group)
                                <option value="{{ $group['group'] }}">{{ $group['group'] }}</option>
                            @endforeach
                        </select>
                        <label for="select-type">Выбор группы</label>
                    </div>
                    @endif

                    <div class="form-group">
                        <select name="type" id="select-type" class="form-control" size="1">
                            <option value="lectures">Лекции</option>
                            <option value="seminars">Семинары</option>
                            <option value="class">Работа на семинарах</option>
                            <option value="control">Контрольные работы</option>
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

        {!! HTML::script('js/statements/statements.js') !!}
@stop
