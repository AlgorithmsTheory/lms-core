@extends('algorithm.RAMbase')
@section('addl-info-ram')
    <div class="col-lg-12">
        <article class="margin-bottom-xxl">
            <p class = 'lead'>
                Данный эмулятор предназначен для получения навыков написания алгоритмов, а также для проверки решения задач. Перед работой ВНИМАТЕЛЬНО ознакомьтесь со справкой (кнопка "Помощь")
            </p>
        </article>
    </div>
@stop
@section('help-ram')
    <a class="btn btn-block btn-primary" href="#offcanvas-demo-right" data-toggle="offcanvas" name = "btn_help">
        <span>Помощь </span><i class="md md-help"></i>
    </a>
@stop
@section('addl-blocks-ram')
@include('algorithm.RAMhelp')
@stop
