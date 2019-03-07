<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" >
<head>
    @yield('head')
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::script('js/jquery.js') !!}
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter41063559 = new Ya.Metrika({ id:41063559, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/41063559" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
</head>
<body class="menubar-hoverable header-fixed" >
    <div id="base">
        <div class="offcanvas">
            </div>
<section>

    <nav class="navbar navbar-fixed-top style-primary">
        <div class="container">

            <div class="navbar-header">
                {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">--}}
                {{--<span class="sr-only">Toggle navigation</span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--</button>--}}
                <a class="" href="{{URL::route('home')}}">
                    <img src="{{URL::asset('/img/AT2.png')}}" width="60px" alt="Главная" style=" padding-right: 10px;">
                </a>
            </div>

            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="btn btn-primary dropdown-toggle" id="dropdownChoiceTestMode" data-toggle="dropdown">
                            <span>Тестирование </span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownChoiceTestMode">
                            <li><a href="{{URL::route('train_tests')}}" class="btn">Тренировочные</a></li>
                            <li><a href="{{URL::route('adaptive_tests')}}" class="btn">Адаптивные</a></li>
                            <li><a href="{{URL::route('control_tests')}}" class="btn">Контрольные</a></li>
                        </ul>
                    </li>
                    <li><a href="{{URL::route('library_index')}}" class="btn">Библиотека</a></li>
                    <li>
                        <a class="btn btn-primary dropdown-toggle" id="dropdownChoiceEmulator" data-toggle="dropdown">
                            <span>Эмуляторы </span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownChoiceEmulator">
                            <li><a href="{{URL::route('MT')}}" class="btn">Тьюринг</a></li>
                            <li><a href="{{URL::route('HAM')}}" class="btn">Марков</a></li>
                            <li><a href="{{URL::route('recursion_index')}}" class="btn">Рекурсия</a></li>
                            <li><a href="{{URL::route('Post')}}" class="btn">Пост</a></li>
                            <li><a href="{{URL::route('MMT')}}" class="btn">Тьюринг (3 ленты)</a></li>
                            <li><a href="{{URL::route('RAM')}}" class="btn">RAM</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{URL::route('personal_account')}}" class="btn"><span class="glyphicon glyphicon-user"></span></a></li>
                    <li><a href="{{URL::route('logout')}}" class="btn"><span class="glyphicon glyphicon-log-out"></span></a></li>
                </ul>
            </div>
        </div>
    </nav>

<div class="section-body" style="margin-top: 80px;">
@yield('content')
    <form action="" method="POST" id="forma" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
</div>
</section>

@yield('js-down')
{!! HTML::script('js/ram/bootstrap.min.js') !!}
{!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
{!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
{!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}

</body>
</html>
