<html>
<body>
<h1>Добро пожаловать в систему тестирования</h1>
<ul>
    @foreach($widgets as $widget)
    <li>{!! $widget !!}</li>
    @endforeach
</ul>
</body>
</html>