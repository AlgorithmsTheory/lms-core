<html>
<body>
<h1>Добро пожаловать в систему тестирования!</h1>

     {!! link_to_route('question_create', 'Добавить новый вопрос') !!} <br>
     {!! link_to_route('test_create', 'Добавить новый тест') !!} <br>
     {!! link_to_route('lecture', 'Перейти на страницу тестов', array(3, '#3.1'))!!} <br>
     {!! HTML::link('library/lecture/3') !!}
     {!! HTML::image($image) !!}
     <img src="img/questions/title/94213.jpg">



</body>
</html>