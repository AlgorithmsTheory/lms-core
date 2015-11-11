<html>
<body>
<form action="{{URL::route('question_form')}}" method="POST" class="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
<p>Логин</p><input type="text" name="username"><br>
<p>Пароль</p><input type="text" name="password"><br>
<input type="submit" name="check" value="Войти">
</form>
</body>
</html>