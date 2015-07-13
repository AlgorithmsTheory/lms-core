<html>
<body>
<h1>Добро пожаловать в систему тестирования {{$username}}!</h1>
{!! link_to_route('question_enter', 'Войти') !!} <br>
<h2>Здесь Вы можете пройти тест </h2>

     {!! link_to_route('question_create', 'Добавить новый вопрос') !!} <br>
    <!--{!! link_to_route('question_kill_session', 'Удалить сессию') !!} <br> -->
    <!--{!! link_to_route('question_showtest', 'Перейти на страницу тестов', ['1']) !!} <br> -->
    {!! link_to_route('tests', 'Перейти на страницу тестов') !!}

</body>
</html>