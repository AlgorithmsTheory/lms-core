@extends('templates.base')
@section('head')
    <title>Лекция 6</title>

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


@stop
@section('content')

<!-- BEGIN BLANK SECTION -->
<section>
    <div class="section-header">
        <ol class="breadcrumb">
            <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
            <li class="active">Лекция 6. Множества: определение и основные свойства..</li>
        </ol>
    </div><!--end .section-header -->
    <div class="section-body">
    </div><!--end .section-body -->
</section>
<div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
<article class="style-default-bright">
<div class="card-body">
<article style="margin-left:10%; margin-right:10%; text-align: justify">
	<a name="2.1"></a>

		


<p style="margin-left:36.0pt"><strong><em><a name="6">Множество (по Тьюрингу)</a></em></strong><em> <strong>&ndash; </strong>это объединение в одно общее объектов, хорошо различимых нашей интуицией или нашей мыслью.</em></p>

<p style="margin-left:36.0pt"><span style="line-height:1.6em">Можно привести другое определение множества:</span></p>

<p style="margin-left:36.0pt"><strong><em><a name="61">Множество (по Кантору)</a></em></strong><em> &ndash; это совокупность объектов безразлично какой природы, неизвестно существующих ли, рассматриваемая как единое целое.</em></p>

<p><strong>Дополнительные определения и операции над множествами</strong></p>

<ol>
	<li>Множество, которое не имеет ни одного элемента, называется пустым и обозначается <em>&Oslash;</em>.</li>
	<li>Единичное множество &ndash; множество, все элементы которого тождественны.</li>
	<li>Множество М<sup>1</sup> называется подмножеством множества М тогда и только тогда, когда любой элемент множества М<sup>1</sup> принадлежит множеству М.</li>
	<li>Множества называются равными, если они имеют одни и те же элементы.</li>
	<li>Подмножество М<sup>1</sup> множества М называется <em>собственным</em> подмножеством множества М, если М<sup>1</sup> является его подмножеством, но при этом существует хотя бы один элемент, принадлежащий М, но не принадлежащий М<sup>1</sup>.</li>
	<li>Пусть А и В &ndash; два множества. Множество М=А U В такое, что его каждый элемент принадлежит А или В (а возможно и А и В), называется суммой или объединением множеств А и В.</li>
	<li>Пусть А и В &ndash; два множества. Множество М=А &cap; В такое, что его каждый элемент принадлежит и А и В одновременно, называется пересечением множеств А и В.</li>
	<li>Пусть А и В &ndash; два множества. Множество М=А \ В такое, что оно состоит из тех элементов множества А, которых нет во множестве В, называется разностью множеств А и В, или дополнением В до А.</li>
	<li>Пусть А и В &ndash; два множества. Множество М=А &times; В такое, что оно образовано из всех пар (a, b) таких, что a принадлежит A и b принадлежит B, называется декартовым произведением множеств А и В.</li>
</ol>

<p><em>Пусть А = {а,</em><em>b</em><em>}; В = {</em><em>m</em><em>,</em><em>n</em><em>} </em></p>

<p><em>Тогда А</em>&times;<em>В = {(</em><em>a</em><em>,</em><em>m</em><em>),(</em><em>a</em><em>,</em><em>n</em><em>),(</em><em>b</em><em>,</em><em>m</em><em>),(</em><em>b</em><em>,</em><em>n</em><em>)}</em></p>

<ol>
	<li>Пусть А &ndash; множество. Множество М, элементами которого являются подмножества множества А, включая само А и пустое множество, называется множеством всех подмножеств множества А или булеаном А и обозначается&nbsp; Р(А).</li>
</ol>

<p><em>Пусть</em> <em>А</em><em> = {</em><em>а</em><em>,b,c} </em></p>

<p><em>Тогда</em><em> M= </em><em>Р</em><em>(</em><em>А</em><em>)={&Oslash;, (a), (b), (c), (a,b), (a,c), (b,c), (a,b,c)}</em></p>

<ol>
	<li>Отображением f множества А в множество В называется некое правило, по которому каждому элементу множества А ставят в соответствие элемент множества В.</li>
	<li>Множество всех отображений множества А в В обозначается как В<sup>А</sup> (В в степени А).</li>
</ol>

<p><em>Пусть А = {а,</em><em>b</em><em>,</em><em>c</em><em>}; В = {</em><em>m</em><em>,</em><em>n</em><em>} </em></p>

<p><em>Тогда </em><em>В<sup>А</sup> это набор функций </em><em>f<sub>i</sub></em><em> приведенных в таблице 2.1 (1).</em></p>

<p>Таблица 2.1 (1)</p>

<table border="1" cellpadding="0" cellspacing="0" style="width:543px">
	<tbody>
		<tr>
			<td style="width:59px">
			<p><em>A</em></p>
			</td>
			<td style="width:49px">
			<p><em>f<sub>1</sub>(A)</em></p>
			</td>
			<td style="width:47px">
			<p><em>f<sub>2</sub>(A)</em></p>
			</td>
			<td style="width:47px">
			<p><em>f<sub>3</sub>(A)</em></p>
			</td>
			<td style="width:47px">
			<p><em>f<sub>4</sub>(A)</em></p>
			</td>
			<td style="width:47px">
			<p><em>f<sub>5</sub>(A)</em></p>
			</td>
			<td style="width:47px">
			<p><em>f<sub>6</sub>(A)</em></p>
			</td>
			<td style="width:47px">
			<p><em>f<sub>7</sub>(A)</em></p>
			</td>
			<td style="width:47px">
			<p><em>f<sub>8</sub>(A)</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:59px">
			<p><em>a</em></p>
			</td>
			<td style="width:49px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>M</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:59px">
			<p><em>b</em></p>
			</td>
			<td style="width:49px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
			<td style="width:47px">
			<p><em>N</em></p>
			</td>
			<td style="width:47px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:59px">
			<p><em>c</em></p>
			</td>
			<td style="width:49px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
			<td style="width:47px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>N</em></p>
			</td>
			<td style="width:47px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
			<td style="width:47px">
			<p><em>m</em></p>
			</td>
			<td style="width:47px">
			<p><em>n</em></p>
			</td>
		</tr>
	</tbody>
</table>

<p><span style="line-height:1.6em">Каждая такая функция задана своими значениями в каждой из трех точек области определенности.</span></p>

<p><span style="line-height:1.2em">&sect; 6.2. Равномощные множества и кардинальные числа</span></p>

<p style="margin-left:36.0pt"><strong><em><a name="62">Мощность множества</a></em></strong><em> (по Кантору) &ndash; это та общая идея, которая остается у нас, когда мы, мысля об этом множестве, отвлекаемся как от всех свойств его элементов, так и от их порядка.</em></p>

<p style="margin-left:36.0pt"><span style="line-height:1.6em">Можно привести другое определение мощности:</span></p>

<p style="margin-left:36.0pt"><strong><em><a name="63">Мощность множества</a></em></strong><em> &ndash; это характеристика, которая объединяет данное множество с другими множествами, применение процедуры сравнения к которым дает основание предполагать, что каждый элемент одного множества имеет парный элемент из другого множества и наоборот.</em></p>

<p style="margin-left:36.0pt"><span style="line-height:1.6em">Далее мощность будем называть </span><strong style="line-height:1.6em"><em>кардинальным числом </em></strong><span style="line-height:1.6em">множества.</span></p>

<p><strong><em>Кардинальные числа некоторых множеств</em></strong></p>

<p>1. Мощность пустого множества равна 0: |<em> &Oslash;</em> |=0.</p>

<p>2. Мощность множества из одного элемента равна 1: <strong>|</strong>{a}<strong>|</strong>=1.</p>

<p>3. Если множества равномощны (A~B), то их кардинальные числа равны: |A|=|B|.</p>

<p>4. Если А - подмножество В и &nbsp;$ C: (A~C)&amp;(C &sube; B), то кардинальное число А не превосходит кардинального числа В, т.е.|A|&le;|B|.</p>

<p>5. Мощность булеана множества А равна 2<sup>|А|</sup>: |P(A)|=2<sup>|А|</sup></p>

<p>6. Мощность множества всех отображений А в В равна |В<sup>|А|</sup>|: |В<sup>А</sup>|=|В<sup>|А|</sup>|</p>

<p><strong style="line-height:1.6em">Конечные, счетно-бесконечные и несчетные множества чисел</strong></p>

<p>Можно классифицировать множества, опираясь на такой признак, как конечность.</p>

<p style="margin-left:36.0pt"><strong><em><a name="64">Конечное множество</a></em></strong><em> &ndash; множество, состоящее из конечного числа элементов, его кардинальное число совпадает с одним из натуральных чисел. В противном случае множество называется <strong><a name="65">бесконечным</a></strong>.</em></p>

<p>Тогда все множества делятся на два класса <strong>конечные</strong> и <strong>бесконечные</strong>, которые в свою очередь делятся на два подкласса: <strong>счетно-бесконечные</strong> и <strong>несчетные</strong>.</p>

<p style="margin-left:36.0pt"><strong><em><a name="66">Счетно-бесконечные</a></em></strong><em> - бесконечные множества, равномощные множеству натуральных чисел (их элементы можно пронумеровать натуральными числами без пропусков и повторений).</em></p>

<p style="margin-left:36.0pt"><strong><em><a name="67">Несчетные</a></em></strong><em> - бесконечные множества, не равномощные множеству натуральных чисел.</em></p>

<p>Можно классифицировать множества и по другому признаку: счетности. Тогда все множества делятся на два класса: <strong>счетные</strong> и <strong>несчетные.</strong> <strong>Счетные</strong> множества в свою очередь делятся на два подкласса: <strong>конечные</strong> и <strong>счетно-бесконечные</strong>.</p>

<p style="margin-left:36.0pt"><strong><em><a name="68">Счетное множество</a></em></strong><em> &ndash; это множество, являющееся конечным или счетно-бесконечным.</em></p>

<p>Важное свойство <strong><u>конечных</u> </strong>множеств: конечные множества не равномощны никакому своему собственному подмножеству.</p>

<p>Важное свойство <strong><u>бесконечных</u></strong> множеств: бесконечное собственное подмножество бесконечного множества <em>может быть</em> равномощно самому множеству (внимание, именно &laquo;может быть&raquo;, а вовсе не &laquo;всегда&raquo; - пример тому несчетные множества, рассмотренные далее).</p>

<p>Иллюстрацией данного факта могут служить два известных парадокса.</p>

<p><strong><u>Парадокс Галилея</u>&nbsp;&nbsp;</strong><strong style="line-height:1.6em">Хотя большинство натуральных чисел не является квадратами, всех натуральных чисел не больше, чем квадратов (если сравнивать эти множества по мощности).</strong></p>

<p style="margin-left:36.0pt"><strong><u>Доказательство</u></strong></p>

<p>Рассмотрим множество квадратов натуральных чисел:</p>

<p>1, 4, 9, 16, 25, 36,&hellip; Назовем его N<sub>1</sub>. Пусть его мощность равна &nbsp;|N<sub>1</sub>|. По построению N<sub>1</sub> &sub; N (N<sub>1</sub> собственное подмножество N). Пронумеруем множество N<sub>1 </sub>натуральным рядом: 1 &rarr;1 , 4 &rarr;2, 9 &rarr;3, 16 &rarr;4, 25 &rarr;5, 36 &rarr;6, ...</p>

<p>Т.о. можно построить взаимнооднозначное соответствие, доказав, что |N<sub>1</sub>|=|N|, значит, квадратов натуральных чисел столько же, сколько и самих натуральных чисел, <strong>Q.E.D.</strong></p>

<p><strong style="line-height:1.6em"><u>Парадокс Гильберта</u></strong></p>

<p><strong>Если гостиница с бесконечным количеством номеров полностью заполнена, в неё можно поселить ещё посетителей, даже бесконечное число. </strong></p>

<p style="margin-left:36.0pt"><strong><u>Доказательство</u></strong></p>

<p>Первого постояльца следует поселить во второй номер, второго &ndash; в третий, далее аналогично, n-ого в (n+1)-ый. Поскольку номеров бесконечное количество, места всем хватит, т.к. для каждого натурального n найдется число n+1. Подобную процедуру можно повторять столько, сколько потребуется,<strong> Q.E.D.</strong></p>

<p>Это оригинальная версия парадокса, в ней под бесконечным числом постояльцев следует понимать счетно-бесконечное число. Для обозначения мощности конечных множеств используются натуральные числа. Для обозначения мощности бесконечных множеств нужны числа иного рода, их называют <a name="69">трансфинитными</a>.</p>

<p style="margin-left:36.0pt"><strong><em>Трансфинитное число </em></strong><em>(</em><em>finis</em><em> &ndash;&nbsp; &ldquo;конец&rdquo;, лат.) </em><em>&ndash; кардинальное число бесконечного множества.</em></p>

<p style="margin-left:36.0pt"><strong style="line-height:1.6em"><em>Алеф-нуль (</em></strong><strong>&alefsym;</strong><strong style="line-height:1.6em"><em><sub>0</sub>) </em></strong><strong style="line-height:1.6em"><em>&ndash;</em></strong><span style="line-height:1.6em"> первое трансфинитное число. По определению это мощность множества всех натуральных чисел. Это наименьшая бесконечная мощность.&nbsp;</span></p>


			</article></article>	</div></div>
@stop
@section('js-down')
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
@stop