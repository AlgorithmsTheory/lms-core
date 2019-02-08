<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" >
<head>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::script('js/jquery.js') !!}
    @yield('head')
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
                </div>

                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{URL::route('tests')}}" class="btn">Тестирование</a></li>
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
        </div>
    </section>
    <div class="offcanvas">
        @yield('right-off-canvas')
    </div>
</div>

{!! HTML::script('js/ram/bootstrap.min.js') !!}
{!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
{!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
{!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
@yield('js-down')

</body>
</html>