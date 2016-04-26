@extends('templates.base')
@section('head')
    <title>Ведомости</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::script('js/jquery.js') !!}
    <meta name="csrf_token" content="{{ csrf_token() }}" />
@stop





@section('content')
        <div class="card">
            <div class="card-body">
                <br>
                <br>
                <form action="" method="" class="form" id="forma">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <textarea  class="form-control textarea3" id="group_num" rows="1" placeholder="Номер группы" required></textarea>
                        <label for="textarea3">Группа</label>
                    </div>
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

        {!! HTML::script('js/statements/statements.js') !!}
@stop
