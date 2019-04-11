<!DOCTYPE html>
<html>
<head>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/full.css') !!}
{{--    {!! HTML::style('css/tests_list.css') !!}--}}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}

    <title>Algorithms theory LMS</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter41063559 = new Ya.Metrika({ id:41063559, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/41063559" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
</head>
<body class="full2">
<div class="col-md-12 col-sm-6 card style-primary text-center">
    <h1 class="text-default-bright">Справочно-обучающая система по курсу ДМ (ТА и СВ)</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="card">
                <div class="card-head">
                    <ul class="nav nav-tabs nav-justified" data-toggle="tabs">
                        <li id="login-form-link" class="active"><a href="#" id="">Авторизация</a></li>
                        <li id="register-form-link"><a href="#" id="">Регистрация</a></li>
                        <li id="reset-form-link"><a href="#" id="">Восстановление</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" action="{{URL::route('login')}}" method="post" data-toggle="validator" class="form" role="form" >
                                 {!! csrf_field() !!}

                                <label id="loginError" class="text-danger" hidden>Пользователь с таким email не зарегистрирован!</label>

                                <div class="form-group">
                                    <input type="email" name="email" value="{{ old('email') }}" id="email" tabindex="1" class="form-control checkEmail" required>
                                    <label for="email">Email</label>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2" class="form-control" required>
                                    <label for="password">Пароль</label>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-primary" value="Авторизоваться">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="register-form" action="{{URL::route('register')}}" method="post" data-toggle="validator" role="form" class="form" style="display: none;">
                                 {!! csrf_field() !!}

                                <label id="registerError" class="text-danger" hidden>Пользователь с таким email уже зарегистрирован!</label>


                                <div class="form-group">
                                    <input type="text" name="first_name" pattern="^[а-яА-Я][а-яА-Я0-9-_\.]{1,20}$" data-error="Введите корректное имя" value="{{ old('first_name') }}" id="first_name" tabindex="1" class="form-control" required>
                                    <label for="first_name">Имя</label>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="last_name" pattern="^[а-яА-Я[а-яА-Я0-9-_\.]{1,20}$" data-error="Введите корректную фамилию" value="{{ old('last_name') }}" id="last_name" tabindex="1" class="form-control" required>
                                    <label for="last_name">Фамилия</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" value="{{ old('email') }}" id="email" data-error="Введите корректный email" tabindex="1" class="form-control checkEmailUnique" required>
                                    <label for="email">Email</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">

                                    <select name="group" id="group" class="form-control" size="1">
                                        <option value="0"></option>
                                        <option value="0">Простой пользователь</option>
                                        <option value="0">Преподаватель</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group['group_id'] }}">{{ $group['group_name'] }}</option>/td>
                                        @endforeach
                                    </select>
                                    <label for="select-type">Выберите</label>

                                    {{--<input type="number" name="group" data-minlength="3" max="999" value="{{ old('group') }}" id="group" tabindex="1" data-error="Нужно три последние цифры!" class="form-control">--}}
                                    {{--<label for="group">Группа (только три последние цифры, например 221)</label>--}}
                                    {{--<div class="help-block with-errors"></div>--}}
                                </div>
                                <div class="form-group">
                                    <input type="password" data-minlength="6" name="password" tabindex="2" id="inputPassword" class="form-control" required data-error="Введите корректный пароль">
                                    <label for="inputPassword">Пароль</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" data-match-error="Пароли не совпадают" data-match="#inputPassword" required tabindex="2" class="form-control" id="confirm" data-error="Введите подтверждение пароля">
                                    <label for="confirm">Подтверждение пароля</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" tabindex="4" class="form-control btn btn-primary" value="Зарегистрироваться">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="reset-form" method="POST" action="{{URL::route('passEmailPost')}}" data-toggle="validator" role="form" class="form"  style="display: none;">
                                {!! csrf_field() !!}

                                <label id="restoreError" class="text-danger" hidden>Пользователь с таким email не зарегистрирован!</label>

                                <div class="form-group">
                                    <input type="email" name="email" value="{{ old('email') }}" id="email" data-error="Введите корректный email!" tabindex="1" class="form-control checkRestoreEmail" required>
                                    <label for="email">Email</label>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <button type="submit" class="form-control btn btn-primary" value="Зарегистрироваться">
                                                Отправить письмо
                                            </button>
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

{!! HTML::script('js/modules.js') !!}
{!! HTML::script('js/administration/checkEmail.js') !!}

</body>
</html>