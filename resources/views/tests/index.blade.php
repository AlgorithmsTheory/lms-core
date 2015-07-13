<html>
<body>
<h1>Добро пожаловать в систему тестирования</h1>
<h2>Контрольные тесты</h2>
<ul>
    @for ($i=0; $i<$ctr_amount; $i++)
    <li>{!! link_to_route('question_showtest', $ctr_names[$i], [$ctr_tests[$i]]) !!}</li>
    @endfor
</ul>
<h2>Тренировочные тесты</h2>
<ul>
    @for ($i=0; $i<$tr_amount; $i++)
    <li>{!! link_to_route('question_showtest', $tr_names[$i], [$tr_tests[$i]]) !!}</li>
    @endfor
</ul>
</body>
</html>