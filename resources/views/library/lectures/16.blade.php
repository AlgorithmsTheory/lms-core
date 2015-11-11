<!DOCTYPE html>
<html lang="en">
<head>
    <title>Лекция 16</title>

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
            <li class="active">Лекция 16. Сложность вычислений.</li>
        </ol>
    </div><!--end .section-header -->
    <div class="section-body">
    </div><!--end .section-body -->
</section>
<div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
<article class="style-default-bright">
<div class="card-body">
<article style="margin-left:10%; margin-right:10%; text-align: justify">
			
		

		
<h3>Полиномиальные и экспоненциальные функции</h3>

<p>Введем понятие <strong><em>верхнего и нижнего порядка </em></strong>одной функции относительно другой функции.</p>

<p style="margin-left:36.0pt"><em>Назовем арифметическую функцию f(x) <strong>функцией одного <a name="162">верхнего порядка</a></strong> с функцией g(x) и пишем f(x) = O(g(x)), если существует такое натуральное число c &gt; 0, что, в конце концов (т. е. начиная с некоторого </em><em>x</em><em>) получим &nbsp;f(x) </em><em>&pound;</em><em> c∙g(x).</em></p>

<p><u>Пример</u>:</p>

<p>Рассмотрим две функции: <em>f<sub>1</sub>(x)= 2</em><em>x</em><em> + 3</em> и &nbsp;<em>f<sub>2</sub>(x) = </em><em>x</em><em><sup>2</sup></em> .</p>

<p>&nbsp;&nbsp;&nbsp; Таблица 5.1.(1)</p>

<table align="center" border="1" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td style="width:43px">
			<p>x</p>
			</td>
			<td style="width:72px">
			<p>2x+3</p>
			</td>
			<td style="width:72px">
			<p>x<sup>2</sup></p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>0</p>
			</td>
			<td style="width:72px">
			<p>3</p>
			</td>
			<td style="width:72px">
			<p>0</p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>1</p>
			</td>
			<td style="width:72px">
			<p>5</p>
			</td>
			<td style="width:72px">
			<p>1</p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>2</p>
			</td>
			<td style="width:72px">
			<p>7</p>
			</td>
			<td style="width:72px">
			<p>4</p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>3</p>
			</td>
			<td style="width:72px">
			<p>9</p>
			</td>
			<td style="width:72px">
			<p>9</p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>4</p>
			</td>
			<td style="width:72px">
			<p>11</p>
			</td>
			<td style="width:72px">
			<p>16</p>
			</td>
		</tr>
	</tbody>
</table>

<p>Таким образом, <em>x</em><em><sup>2</sup></em> рано или поздно обгонит любую линейную функцию и можно записать <em>2х+3=О(</em><em>x</em><em><sup>2</sup></em><em>).</em></p>

<p style="margin-left:36.0pt"><em>Назовем арифметическую функцию f(x) функцией <strong>одного <a name="163">нижнего порядка</a></strong> с функцией g(x) и пишем f(x)=о(g(x)), если существует такое натуральное число &nbsp;c &gt; 0, что в конце концов (начиная с некоторого </em><em>x</em><em>) получим f(x) </em><em>&sup3;</em><em> c</em>∙<em>g(x).</em></p>

<p style="margin-left:36.0pt"><u>Пример</u>:&nbsp; 2<sup>x</sup> =о(x + 2).</p>

<p>Рассмотрим две функции&nbsp; <em>f<sub>1</sub>(x)= 2<sup>x</sup> </em>и &nbsp;<em>f<sub>2</sub>(x) = x + 2. </em></p>

<p>Таблица 5.1.(2)</p>

<table align="center" border="1" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td style="width:43px">
			<p>x</p>
			</td>
			<td style="width:72px">
			<p>2<sup>x</sup></p>
			</td>
			<td style="width:72px">
			<p>x+2</p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>0</p>
			</td>
			<td style="width:72px">
			<p>1</p>
			</td>
			<td style="width:72px">
			<p>2</p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>1</p>
			</td>
			<td style="width:72px">
			<p>2</p>
			</td>
			<td style="width:72px">
			<p>3</p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>2</p>
			</td>
			<td style="width:72px">
			<p>4</p>
			</td>
			<td style="width:72px">
			<p>4</p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>3</p>
			</td>
			<td style="width:72px">
			<p>8</p>
			</td>
			<td style="width:72px">
			<p>5</p>
			</td>
		</tr>
		<tr>
			<td style="width:43px">
			<p>4</p>
			</td>
			<td style="width:72px">
			<p>16</p>
			</td>
			<td style="width:72px">
			<p>6</p>
			</td>
		</tr>
	</tbody>
</table>

<p>Таким образом<em>, 2<sup>x</sup></em> рано или поздно станет больше любого полинома. При малых размерах экспоненциальный алгоритм лучше полиномиального алгоритма</p>

<p style="margin-left:36.0pt"><em>Назовем арифметическую функцию f(x) функцией <strong><a name="164">одного порядка с функцией</a></strong> g(x), если она одного верхнего и одного нижнего порядка с функцией g(x), f(x) = o(g(x)) &amp; f(x) = О(g(x)).</em></p>

<p style="margin-left:36.0pt"><em>Функции одного верхнего порядка с полиномами называются <strong>полиномиальными функциями.</strong></em></p>

<p>Это не только все полиномы, но и некоторые трансцендентные функции. Все остальные функции экспоненциальные в широком смысле этого слова.</p>

<p style="margin-left:36.0pt"><em>Функции одного нижнего порядка с экспонентой называются <strong><a name="166">экспоненциальными,</a></strong> <strong>функциями</strong>.</em></p>

<p>Тогда функции между экспоненциальными и полиномиальными называются <strong><em>субэкспоненциальными функциями (сверхполиномиальными). </em></strong>Это функции, значение которых растет быстрее, чем полином, но медленнее, чем экспотента. Экспоненциальные функции в свою очередь разделяются по скорости еще на несколько классов.</p>

<p style="margin-left:36.0pt"><em>Арифметические функции f(x) и g(x) называются <strong><a name="165">полиномиально-связанными</a></strong> или <strong>полиномиально-эквивалентнтными</strong>, если существуют такие многочлены P<sub>1</sub>(x) и P<sub>2</sub>(x), что, в конце концов (начиная с некоторого числа) f(x)</em><em>&pound;</em><em>P<sub>1</sub>∙g(x) и g(x)</em><em>&pound;</em><em>P<sub>2</sub>∙f(x).</em></p>

<p><u>Пример</u>:</p>

<p>f(x)=2x+3,&nbsp;&nbsp;&nbsp;&nbsp; p<sub>1</sub>(x)=3x+7,&nbsp;&nbsp;&nbsp;&nbsp; p<sub>2</sub>(x)=1+x<sup>5</sup>,&nbsp;&nbsp;&nbsp; g(x)=x<sup>3</sup>.</p>

<p>2x+3 &pound; (3x+7)∙x<sup>3 </sup>&nbsp;и x<sup>3 </sup>&pound; (1+x<sup>5</sup>)∙(2x+3)</p>

<p>=&gt; f(x) и g(x) полиномиально связаны или эквивалентны.</p>

<h3>&sect;16.2 Временная и пространственная сложность</h3>

<p style="margin-left:36.0pt"><strong><em><a name="160">Временной сложностью алгоритма </a></em></strong><em>T(x) называется число его шагов, необходимых для решения данной задачи размера x в худшем случае.</em></p>

<p style="margin-left:36.0pt"><strong><em><a name="161">Пространственная сложность алгортима </a></em></strong><em>S(x) - это число единиц памяти, необходимых для решения задачи размера </em><em>x</em> <em>в худшем случае.</em></p>

<p>В конечном счете, функции пространственной и временной сложности&nbsp; должны определятся для конкретных машин (в операциях). Но теория сложности алгоритмов определяет общие типы алгоритмов, дифференцируя их по трудоемкости на два класса:</p>

<ul>
	<li>полиномиальные алгоритмы;</li>
	<li>экспоненциальные алгоритмы.</li>
</ul>

<p style="margin-left:36.0pt"><em>Алгоритм, обе функции сложности которого полиномиальные, называется <strong>полиномиальным алгоритмом.</strong></em></p>

<p>Такой алгоритм считается хорошим, быстрым, практичным.</p>

<p style="margin-left:36.0pt"><em>Алгоритм, у которого хотя бы одна из двух функций сложности экспоненциальная, называется <strong>экспоненциальным алгоритмом.</strong></em></p>

<p style="margin-left:36.0pt"><em>Задача, решаемая полиномиальным алгоритмом, называется <strong>легкоразрешимой</strong> задачей.</em></p>

<p style="margin-left:36.0pt"><em>Задача, которую нельзя решить полиномиальным алгоритмом, &nbsp;называется <strong>трудноразрешимой.</strong></em></p>

<p>&nbsp;</p>

<p>&nbsp;В число трудноразрешимых задач входят алгоритмически неразрешимые задачи. Неразрешимость есть крайний случай экспоненциальности.</p>

<p>Для наглядности рассмотрим таблицу возможностей алгоритмов, отражающую объем вычислений. Таблица показывает, как долго компьютер, осуществляющий миллион операций в секунду, будет выполнять некоторые медленные алгоритмы.</p>

<p> Таблица 5.3 (1)</p>

<p><strong><em>{!! HTML::image('img/library/Pic/16.1.jpg', 'a picture', array('style' => 'height:143px; width:779px')) !!}</em></strong></p>

<p>Производительность современных приличных компьютеров &ndash; несколько десятков миллиардов операций в секунду, у суперкомпьютеров может доходить до нескольких терафлопс (1 терафлопс=1 триллион операций в секунду), но вряд ли это будет большим утешением, если потребуется&nbsp; запустить алгоритм сложности N! для массива из 50 объектов.</p>

			</article></article>	</div></div>

<!-- BEGIN JAVASCRIPT -->
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