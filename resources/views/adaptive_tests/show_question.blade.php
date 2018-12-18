<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Тест</title>
    {!! HTML::script('js/adaptive_tests/testPass.js') !!}
    {!! HTML::script('js/jquery.js') !!}
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
                @for ($i=0; $i < $current_question_number; $i++)
                    <li class="NotAnswered" id="{{$i}}"><a href="#form{{$i+1}}" class="SmoothScroll"> {{$i+1}} </a></li>
                @endfor
            </ul>

            <span id="my_timer" class="timer">{{ $left_min }}:{{ $left_sec }}</span> </div>
    </nav>
    <br><br><br>

    {!! $question_widget !!}

    <div class="col-sm-6">
        <input id="check" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" type="button" name="check" value="Следующий">
    </div>

    <div class="col-sm-6">
        {!! Form::open(['method' => 'POST', 'route' => 'drop_adaptive_test', 'id' => 'drop-test', 'name' => 'drop_test']) !!}
        <input id="drop" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-danger" type="submit" name="drop_btn" value="Отказаться">
        {!! Form::close() !!}
    </div>
    <br>
</section>
</body>
</html>