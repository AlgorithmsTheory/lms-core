@extends('algorithm.RAMbase')
@section('addl-info')
    <div class="col-lg-12">
        <article class="margin-bottom-xxl">
            <div name="test_seq"  style="display:none">{{ $test_seq }}</div>
            <p class = 'lead'>
                <button type="button" name="btn_submit" class="btn ink-reaction btn-primary">Проверить работу</button>
                <h3 name="task" style="display:block">{{ $task }}</h3>
            </p>
        </article>
    </div>
@stop
@section('addl-blocks')
@stop