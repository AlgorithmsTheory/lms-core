<!DOCTYPE html>
<html lang="en">
<head>
    <title>Персоналии</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/libs/utils/html5shiv.js') !!}
    {!! HTML::script('js/libs/utils/respond.min.js') !!}
    <![endif]-->


</head>
<body>
<section>

<div class="col-md-12 col-sm-6 card style-primary text-center">
    <h1 class="text-default-bright">Библиотека</h1>
</div>

<!-- BEGIN CONTENT-->
<div id="content">

    <!-- BEGIN BLANK SECTION -->
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
                <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                <li class="active">Персоналии</li>
            </ol>
        </div><!--end .section-header -->
    </section>
    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
        <article class="style-default-bright">
            <div class="card-body">
	<article class="style-default-bright">
		<div class="card-body"> 
		<article style="margin-left:10%; margin-right:10%; text-align: justify">
	<center>		
<table border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td style="width:155px">
                <p><a href="{{URL::route('person', array('markov'))}}">{!! HTML::image('img/library/persons/markov.jpg', 'markov', array('style' => 'float:left; height:200px; width:150px')) !!}</a></p>
			</td>
			<td style="width:154px">
		

			<center><h3>{!! HTML::linkRoute('person', 'Марков Андрей Андреевич (младший)', array('markov')) !!}</h3>

			<p><strong>1903-1979</strong></p></center>
			</td>
			<td style="width:159px">

			<p><a href="{{URL::route('person', array('shennon'))}}"  title="">{!! HTML::image('img/library/persons/shennon.JPG', 'shennon', array('style' => 'float:left; height:195px; width:156px')) !!}</a></p>
			</td>
			<td style="width:154px">
		
			<center><h3>{!! HTML::linkRoute('person', 'Клод Элвуд Шеннон', array('shennon')) !!}</h3>

			<p><strong>1916-2001</strong></p></center>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:155px"><p>&nbsp;</p>
			<p><a href="{{URL::route('person', array('gedel'))}}"  title="">{!! HTML::image('img/library/persons/gedel.png', 'gedel', array('style' => 'float:left; height:190px; width:148px')) !!}</a></p>
			</td>
			<td style="width:154px">
		

			<center><h3>{!! HTML::linkRoute('person', 'Курт Фридрих Гёдель', array('gedel')) !!}</h3>

			<p><strong>1906-1978</strong></p></center>
			</td>
			<td style="width:159px"><p>&nbsp;</p>
			<p><a href="{{URL::route('person', array('gilbert'))}}"  title="">{!! HTML::image('img/library/persons/gilbert.jpg', 'gilbert', array('style' => 'float:left; height:190px; width:152px')) !!}</a></p>
			
			</td>
			<td style="width:154px">
			

			<center><h3>{!! HTML::linkRoute('person', 'Давид Гилберт', array('gilbert')) !!}</h3>

			<p><strong>1862-1943</strong></p></center>
			</td>
		</tr>
		
		<tr>
			<td style="width:155px"><p>&nbsp;</p>
			<p><a href="{{URL::route('person', array('kantor'))}}"  title="">{!! HTML::image('img/library/persons/kantor.jpg', 'kantor', array('style' => 'float:left; height:190px; width:148px')) !!}</a></p>
			</td>
			<td style="width:154px">
		

			<center><h3>{!! HTML::linkRoute('person', 'Георг Кантор', array('kantor')) !!}</h3>

			<p><strong>1845-1918</strong></p></center>
			</td>
			<td style="width:159px"><p>&nbsp;</p>
			<p><a href="{{URL::route('person', array('rassel'))}}"  title="">{!! HTML::image('img/library/persons/rassel.jpg', 'rassel', array('style' => 'float:left; height:190px; width:152px')) !!}</a></p>
			
			</td>
			<td style="width:154px">
			

			<center><h3>{!! HTML::linkRoute('person', 'Бертран Артур Уильям Рассел', array('rassel')) !!}</h3>

			<p><strong>1872-1970</strong></p></center>
			</td>
		</tr>
		
		<tr>
			<td style="width:155px"><p>&nbsp;</p>
			<p><a href="{{URL::route('person', array('turing'))}}"  title="">{!! HTML::image('img/library/persons/turing.jpg', 'turing', array('style' => 'float:left; height:190px; width:148px')) !!}</a></p>
			</td>
			<td style="width:154px">
		

			<center><h3>{!! HTML::linkRoute('person', 'Алан Мэтисон Тьюринг', array('turing')) !!}</h3>

			<p><strong>1912-1954</strong></p></center>
			</td>
			<td style="width:159px"><p>&nbsp;</p>
			<p><a href="{{URL::route('person', array('cherch'))}}"  title="">{!! HTML::image('img/library/persons/cherch.jpg', 'cherch', array('style' => 'float:left; height:190px; width:152px')) !!}</a></p>
			
			</td>
			<td style="width:154px">
			

			<center><h3>{!! HTML::linkRoute('person', 'Алонзо Чёрч', array('cherch')) !!}</h3>

			<p><strong>1903-1995</strong></p></center>
			</td>
		</tr>
	</tbody>
</table>

<p>&nbsp;</p>
			</center>
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