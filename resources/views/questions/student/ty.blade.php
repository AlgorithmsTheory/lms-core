<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_form']) !!}
<p>Логин</p><input type="text" name="username"><br>
<p>Пароль</p><input type="text" name="password"><br>
<input type="submit" name="check" value="Войти">
{!! Form::close() !!}
</body>
</html>