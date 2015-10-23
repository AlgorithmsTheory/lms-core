<html>
<head>
    <title>Результаты</title>
    {!! HTML::style('css/test_style.css') !!}
    <style>
        .css-checkbox{
            display: none;
        }
    </style>
</head>
<h1>Ваши результаты!</h1>
<h2>Вы набрали {{$score}} баллов из 100!</h2>
<h2>Ваша оценка: {{$mark_bologna}}({{$mark_rus}})</h2>
<table>
<?php $i=1;?>
    @foreach($widgets as $widget)
    <tr>
        <td>{!! $widget !!}</td>
        <td>{{$right_or_wrong[$i]}}</td>
    </tr>
    <?php $i++;?>
    @endforeach
</table>

{!! Form::open(['class' => 'smart-blue', 'method' => 'GET', 'route' => 'question_index']) !!}
<button class="button-submit" type="submit">{!! link_to_route('question_index', 'Вернуться на главную') !!}</button>
{!! Form::close() !!}
</html>