
<!DOCTYPE html>
<html>
<head>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/tests_list.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::script('js/jquery.js') !!}
    <title>Laravel</title>

    <script>
        $(function() {

            $('#login-form-link').click(function(e) {
                $("#login-form").delay(100).fadeIn(100);
                $("#register-form").fadeOut(100);
                $('#register-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });
            $('#register-form-link').click(function(e) {
                $("#register-form").delay(100).fadeIn(100);
                $("#login-form").fadeOut(100);
                $('#login-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });

        });

    </script>
</head>
<body class="full2">
<div class="col-md-12 col-sm-6 card style-primary text-center">
    <h1 class="text-default-bright">Образовательный ресурс по "Теории алгоритмов"</h1>
</div>
<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="#" class="active" id="login-form-link">Авторизация</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" id="register-form-link">Регистрация</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" action="{{URL::route('login')}}" method="post" role="form" style="display: block;">

                                {!! csrf_field() !!}

                                <div class="form-group">
                                    <input type="email" name="email" value="{{ old('email') }}" id="email" tabindex="1" class="form-control" placeholder=" Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder=" Пароль">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Авторизоваться">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="register-form" action="{{URL::route('register')}}" method="post" role="form" style="display: none;">

                                {!! csrf_field() !!}

                                <div class="form-group">
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" id="username" tabindex="1" class="form-control" placeholder=" Имя">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" id="username" tabindex="1" class="form-control" placeholder=" Фамилия">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" value="{{ old('email') }}" id="email" tabindex="1" class="form-control" placeholder=" Email">
                                </div>
                                <div class="form-group">
                                    <input type="number" name="group" value="{{ old('group') }}" id="group" tabindex="1" class="form-control" placeholder=" Группа (только три последние цифры)">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" tabindex="2" class="form-control" placeholder=" Пароль">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" tabindex="2" class="form-control" placeholder=" Подтверждение пароля">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" tabindex="4" class="form-control btn btn-register" value="Зарегистрироваться">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
{!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
{!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
</body>
</html>