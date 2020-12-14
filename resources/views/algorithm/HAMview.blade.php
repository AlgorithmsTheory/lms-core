@extends('algorithm.HAMbase')

@section('addl-info-ham')
    <div class="col-lg-12">
        <article class="margin-bottom-xxl">
            <p class = 'lead'>
                Данный эмулятор предназначен для получения навыков написания алгоритмов,
                а также для проверки решения задач. Перед работой ВНИМАТЕЛЬНО ознакомьтесь
                со справкой (кнопка "Помощь")
            </p>
        </article>
    </div>
@stop

@section('task-ham')
    <div class="card-body">
        <div class="col-lg-12">
            <div class="form" role="form">
                <div class="form-group floating-label">
                    <textarea name="task_text" class="form-control" rows="3" placeholder="Для Вашего удобства здесь можно написать условие задачи"></textarea>
                    <label style="top:-15px">Условие задачи: </label> 
                </div>
            </div>
        </div>
    </div>
@stop

@section('help-ham')
    <a class="btn btn-raised ink-reaction btn-primary" href="#offcanvas-demo-right" data-toggle="offcanvas">
        <i class="md md-help"></i>
    </a>
@stop

@section('addl-blocks-ham')
@include('algorithm.HAMhelp')
@stop
