
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Тест</title>

    {!! HTML::style('css/test_style.css') !!}
    {!! HTML::script('js/superForm.js') !!}
    {!! HTML::script('js/jquery.js') !!}


</head>
<body onload="startTimer()">
<nav class="fixed-nav">
    <div class="menu wrapper">
        <ul>
            @for ($i=0; $i<$amount; $i++)
            <li class="NotAnswered" id="{{$i}}"><a href="#form{{$i+1}}" class="SmoothScroll"> {{$i+1}} </a></li>
            @endfor
        </ul>
        <span id="my_timer" class="timer" ">00:10:10</span>
    </div>
</nav>
<br><br>
<?php $i=1;?>
@foreach($widgets as $widget)
<br id="form{{$i}}">
<?php $i++;?>
{!! $widget !!}
@endforeach
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'name' => 'super', 'onsubmit' => 'return sendForm();']) !!}
@for ($i = 0; $i < $amount; $i++)
<input id="super{{$i}}" type="hidden" name="{{$i}}" value="">
@endfor
<input id="amount" type="hidden" name="amount" value="{{ $amount }}">
<input type="hidden" name="id_test" value="{{ $id_test }}">
<input id="check" onClick="fillSuper()" class="button-submit" type="submit" name="check" value="Отправить">
{!! Form::close() !!}
{!! HTML::script('js/toolbar.js') !!}
</body>
</html>