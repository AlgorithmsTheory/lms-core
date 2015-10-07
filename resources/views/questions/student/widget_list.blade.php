<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Тест</title>

    {!! HTML::style('css/test_style.css') !!}
    {!! HTML::script('js/superForm.js') !!}
    {!! HTML::script('js/jquery.js') !!}
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}

</head>
<body onload="startTimer()">
<nav class="fixed-nav">
    <div class="menu wrapper">
        <ul>
            @for ($i=0; $i<$amount; $i++)
            <li class="NotAnswered" id="{{$i}}"><a href="#form{{$i+1}}" class="SmoothScroll"> {{$i+1}} </a></li>
            @endfor
        </ul>
        <?php
        // $date = date_create();
        // date_add($date, date_interval_create_from_date_string('30 minutes'));
        // $newDate = date_format($date, 'U') + 30 * 60;
        // echo $newDate + " ";

        $startDate = date_create();
        // echo date_format($startDate, 'H:i:s') . "\n";
        $newDate = date_format($startDate, 'U') + 30 * 60;
        $endDate = date_create();
        date_timestamp_set($endDate, $newDate);
        // echo date_format($endDate, 'H:i:s') . "\n";
        $restDate = date_create();
        date_timestamp_set($restDate, (date_format($endDate, 'U') - date_format($startDate, 'U')));
        // echo date_format($restDate, 'H:i:s') . "\n";

        ?>

        <span id="my_timer" class="timer" "><?php echo date_format($restDate, 'i'); ?>:<?php echo date_format($restDate, 's'); ?> </span> </div>
</nav>
<br><br><br>
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