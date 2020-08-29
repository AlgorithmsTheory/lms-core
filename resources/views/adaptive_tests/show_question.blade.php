<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Тест</title>
    {!! HTML::script('js/modules.js') !!}
    {!! HTML::script('js/superForm.js') !!}
    {!! HTML::script('js/toolbar.js') !!}
    {!! HTML::script('js/adaptive_tests/testPass.js') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::style('css/test_style.css') !!}
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}

</head>
<body onload="startTimer()">
<section>
    <nav class="fixed-nav">
        <div class="menu wrapper">
            <ul>
                @for ($i=0; $i < $current_question_number - 1; $i++)
                    <li class="Answered"><a href="#" class="SmoothScroll"> {{$i+1}} </a></li>
                @endfor
                <li class="Return"><a href="#" class="SmoothScroll"> {{$i+1}} </a></li>
            </ul>

            <span id="my_timer" class="timer">{{ $left_min }}:{{ $left_sec }}</span> </div>
    </nav>
    <br><br><br>

    {!! $question_widget !!}

    {!! Form::open(['method' => 'PATCH', 'route' => 'check_adaptive_test', 'id' => 'super-form', 'name' => 'super']) !!}
    <input id="super0" type="hidden" name="0" value="">
    <input id="id-result" type="hidden" name="id_result" value="{{ $current_result }}">
    <input id="amount" type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="id_test" value="{{ $id_test }}">
    <div class="col-sm-6">
        <input id="check" onClick="fill(0)" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" type="submit" name="check" value="Следующий">
    </div>
    {!! Form::close() !!}

    <div class="col-sm-6">
        {!! Form::open(['method' => 'POST', 'route' => 'drop_adaptive_test', 'id' => 'drop-test', 'name' => 'drop_test']) !!}
        <input id="drop" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-danger" type="submit" name="drop_btn" value="Отказаться">
        {!! Form::close() !!}
    </div>
    <br>
</section>
</body>
</html>