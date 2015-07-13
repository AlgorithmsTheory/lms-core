<html>
{!! HTML::style('css/test_style.css') !!}
<body>
{!! Form::open(['class' => 'smart-blue']) !!}
<h1>Ваши результаты!</h1>
<h2>Вы набрали {{$score}} баллов из 100!</h2>
<h2>Ваша оценка: {{$mark_bologna}}({{$mark_rus}})</h2>

    <br>
<button class="button-submit">{!! link_to_route('question_index', 'Вернуться на главную') !!}</button>
{!! Form::close() !!}
</body>
</html>