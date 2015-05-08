<html>
<body>
<h1>Добро пожаловать в систему тестирования</h1>
<p>Здесь Вы можете добавить новый тестовый вопрос, изменить уже существующий или удалить вопрос </p>

    {!! link_to_route('question_create', 'Добавить новый вопрос') !!} <br>
    {!! link_to_route('question_kill_session', 'Удалить сессию') !!} <br>
    {!! link_to_route('question_showtest', 'Перейти на страницу тестов', ['1']) !!} <br>

 <h2>Список вопросов</h2>
<ul>
@foreach($questions as $question)
    <li>{!! link_to_route('question_show', $question->id_question, [$question->id_question]) !!}</li>
@endforeach
</ul>

</body>
</html>