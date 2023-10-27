<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    @yield('head')
    <style>
        .navbar-header {
            display: flex;
            align-items: center;
            padding: 0 25px;
        }

        .navbar-toggler {
            margin-left: auto;
            background: transparent;
            width: 40px;
            height: 40px;
            color: #fff;
            border: 0;
            outline: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (min-width: 769px) {
            .navbar-toggler {
                display: none;
            }
        }
    </style>
</head>
<body class="@yield('background', '')">
<div id="base">
    <div class="offcanvas">
        @yield('left-off-canvas')
    </div>
    <section>
        <nav class="navbar navbar-fixed-top style-primary">
            <div class="container">
                <div class="navbar-header">
                    <a class="" href="{{URL::route('home')}}">
                        <img src="{{URL::asset('/img/AT2.png')}}" width="60px" alt="Главная" style=" padding-right: 10px;">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false"><title>Menu</title><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path></svg>
                    </button>
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
								<li><a href="{{URL::route('mt2')}}" class="btn">Тьюринг</a></li>
								<li><a href="{{URL::route('ham2')}}" class="btn">Марков</a></li>
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
        </div>
    </section>
    <div class="offcanvas">
        @yield('right-off-canvas')
    </div>
</div>

{!! HTML::script('js/modules.js') !!}
@yield('js-down')

</body>
</html>