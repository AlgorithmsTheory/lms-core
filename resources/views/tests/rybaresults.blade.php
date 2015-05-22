<html>
<body>
<h1>Ваши результаты!</h1>
<h2>Вы набрали {{$score}} баллов из 100!</h2>
@for ($i=0; $i<$number_of_wrong; $i++)
<p>Вы неверно ответили на вопрос {!! link_to_route('question_show', $view[$i], [$view[$i]]) !!}
@endfor
    <br>
    {!! link_to_route('question_index', 'Вернуться на главную') !!}
</body>
</html>