<!DOCTYPE html>
<html lang="en">
<head>
    <title>Дополнительно</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::script('js/jquery.js') !!}
    <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/libs/utils/html5shiv.js') !!}
    {!! HTML::script('js/libs/utils/respond.min.js') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    <![endif]-->


</head>
<body>
<section>

    <nav class="navbar navbar-fixed-top style-primary">
        <div class="container">
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{URL::route('home')}}" class="btn">Главная</a></li>
                    <li><a href="{{URL::route('tests')}}" class="btn">Система тестирования</a></li>
                    <li><a href="{{URL::route('library_index')}}" class="btn">Библиотека</a></li>
                    <li><a href="{{URL::route('in_process')}}" class="btn">Машины Тьюринга</a></li>
                    <li><a href="{{URL::route('in_process')}}" class="btn">Алгоритмы маркова</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{URL::route('logout')}}" class="btn">Выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>

<!-- BEGIN CONTENT-->
<div id="content">

    <!-- BEGIN BLANK SECTION -->
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
                <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                <li class="active">Дополнительно</li>
            </ol>
        </div><!--end .section-header -->
    </section>
    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
        <article class="style-default-bright">
            <div class="card-body">
		<article style="margin-left:10%; margin-right:10%; text-align: justify">

		<div class="card-body style-default-dark">
		<h2>Трансфинитные числа</h2>
		</div>
		<blockquote>
			<p>Трансфинитное число — число, обозначающее величину бесконечно большого множества в виде нижнего индекса. &alefsym;<sub>0</sub> представляет множество всех целых чисел, а &alefsym;<sub>1</sub> представляет размер множества всех реальных чисел. Хотя оба множества бесконечно большие, но множество действительных чисел в некотором смысле больше множества целых (можно показать, что не каждому действительному числу соответствует целое число).</p>

		</blockquote>

        {!! HTML::link('download/dop/Transfinitnie_chisla.pdf', 'Скачать', array('class' => 'btn btn-default')) !!}
		<p>&nbsp;</p>
		<div class="card-body style-default-dark">
		<h2>Трансцендентные числа</h2>
		</div>
		<blockquote>
			<p>Трансцендентное число (от лат. transcendere – переходить, превосходить) — это вещественное или комплексное число, не являющееся алгебраическим — иными словами, число, которое не может быть корнем многочлена с рациональными коэффициентами.</p>
		</blockquote>
            {!! HTML::link('download/dop/Transcendentnie_chisla.pdf', 'Скачать', array('class' => 'btn btn-default')) !!}
		<p>&nbsp;</p>
		<div class="card-body style-default-dark">
		<h2>Машины Поста</h2>
		</div>
		<blockquote>
			<p>Машина Поста — абстрактная вычислительная машина, созданная для уточнения понятия «алгоритм», способная определять, является ли та или иная задача алгоритмически разрешимой, эквивалента машине Тьюринга. </p>
		</blockquote>
            {!! HTML::link('download/dop/Mashini_Posta.pdf', 'Скачать', array('class' => 'btn btn-default')) !!}
		<p>&nbsp;</p>
		<div class="card-body style-default-dark">
		<h2>Парадоксы, связанные с самоотносимостью понятий </h2>
		</div>
		<blockquote>
			<p>Парадокс — это два противоположных, несовместимых утверждения, для каждого из которых имеются кажущиеся убедительными аргументы. Парадоксы представляют собой наиболее интересный случай неявных, безвопросных способов постановки проблем. </p>
		</blockquote>
            {!! HTML::link('download/dop/Paradocs.pdf', 'Скачать', array('class' => 'btn btn-default')) !!}
		<p>&nbsp;</p>
		<div class="card-body style-default-dark">
		<h2>Тест Тьюринга </h2>
		</div>
		<blockquote>
			<p>Тест Тьюринга — эмпирический тест, идея которого была предложена Аланом Тьюрингом в статье «Вычислительные машины и разум», опубликованной в 1950 году в философском журнале «Mind». </p>
		</blockquote>
            {!! HTML::link('download/dop/Turing_test.pdf', 'Скачать', array('class' => 'btn btn-default')) !!}
		<p>&nbsp;</p>
		<div class="card-body style-default-dark">
		<h2>Число <i>е</i> </h2>
		</div>
		<blockquote>
			<p>Число Эйлера – «<i>e</i>» равно 2,7182818284590452353602875… </p>
			<p>	Что же это за магическое число? Чем оно интересно? Почему множество математиков пыталось найти формулу для его вычисления?
</p>
		</blockquote>
            {!! HTML::link('download/dop/E.pdf', 'Скачать', array('class' => 'btn btn-default')) !!}
		<p>&nbsp;</p>
		<div class="card-body style-default-dark">
		<h2>Доказательство трансцендентности числа <i>e</i></h2>
		</div>
		<blockquote>
			<p>В 1874 году Шарль Эрмит доказал трансцендентность числа  <i>e</i>. Речь шла только о том, чтобы построить  <i>e</i>  при помощи циркуля и линейки. Теперь же доказывается не только то, что это невозможно, но нечто гораздо большее, a именно, показано, что  <i>e</i> есть число трансцендентное, т. е. что его вообще нельзя связать с целыми числами никаким алгебраическим соотношением. </p>
		</blockquote>
            {!! HTML::link('download/dop/Dokazatelstvo_transcendentnosti_e.pdf', 'Скачать', array('class' => 'btn btn-default')) !!}
		<p>&nbsp;</p>
		<div class="card-body style-default-dark">
		<h2>Число &pi; </h2>
		</div>
		<blockquote>
			<p> &pi; — математическая константа, равная отношению длины окружности к длине её диаметра. Обозначается буквой греческого алфавита «пи». Старое название — лудольфово число.</p>
		</blockquote>
            {!! HTML::link('download/dop/Pi.pdf', 'Скачать', array('class' => 'btn btn-default')) !!}
		<p>&nbsp;</p>
			<div class="card-body style-default-dark">
		<h2>Континуум-гипотеза </h2>
		</div>
		<blockquote>
			<p>В 1877 году Георг Кантор выдвинул и впоследствии безуспешно пытался доказать так называемую конти́нуум-гипо́тезу, которую можно сформулировать следующим образом:</p>
<i>«Любое бесконечное подмножество континуума является либо счётным, либо континуальным.»
</i>
		</blockquote>
            {!! HTML::link('download/dop/kontinuum-gipoteza.pdf', 'Скачать', array('class' => 'btn btn-default')) !!}


			</article></article>	</div></div>
    {!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
    {!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
    {!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
    {!! HTML::script('js/libs/spin.js/spin.min.js') !!}
    {!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
    {!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    <!-- END JAVASCRIPT -->
</section>
</body>
</html>