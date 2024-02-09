<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Тест</title>
    {!! HTML::script('js/modules.js') !!}
    {!! HTML::script('js/superForm.js') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::style('css/test_style.css') !!}
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}

    {!! HTML::style('css/algorithm/mt2.css') !!}
    {!! HTML::style('css/algorithm/ham2.css') !!}

</head>
<body onload="startTimer()">
<section>
<nav class="fixed-nav">
    <div class="menu wrapper">
        <ul>
            @for ($i=0; $i<$amount; $i++)
            <li class="NotAnswered" id="{{$i}}"><a href="#form{{$i+1}}" class="SmoothScroll"> {{$i+1}} </a></li>
            @endfor
        </ul>


        <span id="my_timer" class="timer">{{$left_min}}:{{$left_sec}}</span> </div>
</nav>
<br><br><br>
<?php $i=1;?>
@foreach($widgets as $widget)
    <br id="form{{$i}}">
    {!! $widget !!}
    <?php $i++;?>
@endforeach

{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'id' => 'super-form', 'name' => 'super', 'onsubmit' => 'return sendForm(true);']) !!}
    @for ($i = 0; $i < $amount; $i++)
        <input id="super{{$i}}" type="hidden" name="{{$i}}" value="">
    @endfor
    <input id="amount" type="hidden" name="amount" value="{{ $amount }}">
    <input id="id_test" type="hidden" name="id_test" value="{{ $id_test }}">
    <div class="col-sm-6">
        <input id="check" onClick="fillSuper()" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" type="submit" name="check" value="Отправить">
    </div>
{!! Form::close() !!}

@if ($test_type == 'Тренировочный')
    <div class="col-sm-6">
        {!! Form::open(['method' => 'POST', 'route' => 'drop_test', 'id' => 'drop-test', 'name' => 'drop_test']) !!}
            <input id="id-result" type="hidden" name="id_result" value="{{ $current_result }}">
            <input id="amount" type="hidden" name="amount" value="{{ $amount }}">
            <input type="hidden" name="id_test" value="{{ $id_test }}">
            <input id="drop" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-danger" type="submit" name="drop_btn" value="Отказаться">
        {!! Form::close() !!}
    </div>
    {!! HTML::script('js/algorithms/saving.js') !!}
    {!! HTML::script('js/algorithms/saving_post.js') !!}
@else
    <script type="text/javascript">
        $("[name=saveTextAsFile]").each(function(){
            $(this).attr("disabled", true);
        });
        $("[name=loadFileAsText]").each(function(){
            $(this).attr("disabled", true);
        });
        $("[name=fileToLoad]").each(function(){
            $(this).attr("disabled", true);
        });
        $("[name=btn_save_doc]").each(function(){
            $(this).attr("disabled", true);
        });
        $("[name=btn_load_doc]").each(function(){
            $(this).attr("disabled", true);
        });
    </script>
    {!! Form::open(['method' => 'POST']) !!}
    {!! Form::close() !!}
@endif

<input id="result_id" type="hidden" value="{{$result_id}}" />

{!! HTML::script('js/toolbar.js') !!}
{!! HTML::script('js/algorithms/superScript.js') !!}

{!! HTML::script('js/ram/ace.js') !!}
{!! HTML::script('js/ram/RAM.js') !!}
{!! HTML::script('js/ram/kontr_RAM.js') !!}

{!! HTML::script('js/algorithms/symbols_post.js') !!}
{!! HTML::script('js/algorithms/post.js') !!}
{!! HTML::script('js/algorithms/kontr_post.js') !!}

{!! HTML::script('js/algorithms/symbols.js') !!}
{!! HTML::script('js/algorithms/kontr_mt.js') !!}
{!! HTML::script('js/algorithms/kontr_ham.js') !!}

{!! HTML::script('js/core/source/App.js') !!}
{!! HTML::script('js/core/source/AppNavigation.js') !!}
{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
{!! HTML::script('js/core/source/AppCard.js') !!}
{!! HTML::script('js/core/source/AppForm.js') !!}
{!! HTML::script('js/core/source/AppNavSearch.js') !!}
{!! HTML::script('js/core/source/AppVendor.js') !!}
{!! HTML::script('js/core/demo/Demo.js') !!}
{!! HTML::script('js/core/demo/DemoUILists.js') !!}
{!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
        
{!! HTML::script('js/algorithms/send.js') !!}

{!! HTML::script('js/algorithm/mt2.js') !!}
{!! HTML::script('js/algorithm/ham2.js') !!}

{!! HTML::script('js/algorithm/mt2ham2_autosave.js') !!}
<br>
</section>
</body>
</html>
