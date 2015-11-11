<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Определения к экзамену</title>

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
							<li class="active">Определения к экзамену</li>
						</ol>
					</div><!--end .section-header -->
				</section>
	<div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
	<article class="style-default-bright">
		<div class="card-body">
		<article style="margin-left:10%; margin-right:10%">


<table border="1" cellpadding="1" cellspacing="" >
	<tbody>
		<tr>
			<td style="width:187px">
			<p style="color: brown">Термин</p>
			</td>
			<td style="width:451px">
			<p style="color: brown">Определение</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			    <p><em>{!! HTML::linkRoute('lecture', 'Алгоритм', array('1#algorithm')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это точное предписание о выполнении в некотором порядке системы операций, определяющих процесс перехода от исходных данных к искомому результату для решения&nbsp; задачи&nbsp; данного типа.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Машина Тьюринга', array('1#mashina')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>абстрактная (воображаемая) &quot;вычислительная машина&quot; некоторого точно охарактеризованного типа, дающая пригодное для целей математического рассмотрения уточнение общего интуитивного представления об алгоритме. </em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Управляющая головка', array('1#golovka')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это некоторое устройство, которое может перемещаться вдоль ленты так, что в каждый рассматриваемый момент времени оно находится напротив определенной ячейки ленты</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Внутренняя память машины', array('1#inside_memory')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это выделенная ячейка памяти, которая в каждый рассматриваемый момент находится в некотором &laquo;состоянии&raquo;.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Конфигурация машины Тьюринга', array('1#config')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это совокупность, образованная содержимым текущей обозреваемой ячейки </em><em>a<sub>j</sub></em>&nbsp; <em>и состоянием внутренней памяти&nbsp; </em><em>S<sub>i</sub></em><em>.</em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Программа машины Тьюринга', array('1#MTprog')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это совокупность&nbsp; команд установленного формата.</em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Тезис Тьюринга', array('1#tesis')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>любой алгоритм можно преобразовать в машину Тьюринга</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Машина В эквивалентна машине А', array('2#1')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>если в соответствующие такты их работы лента машины В содержит всю информацию о ленте машины А. </em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Самоанализирующие машины', array('2#selfanalysis')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это машины, в которых все служебные символы как-либо изображаются ленточными символами.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Универсальная машина', array('2#universal')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>машина Тьюринга, обладающая способностью путём подходящего кодирования выполнить любое вычисление</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Взаимозаменяемые машины Тьюринга', array('4#4')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>Две ма&shy;ши&shy;ны Тью&shy;рин&shy;га, име&shy;ющие один и тот же внешний ал&shy;фа&shy;вит, бу&shy;дем на&shy;зы&shy;вать взаимозаменяемыми, если, ка&shy;ко&shy;во бы ни бы&shy;ло сло&shy;во в их об&shy;щем ал&shy;фа&shy;ви&shy;те, не содер&shy;жа&shy;щее пус&shy;то&shy;го сим&shy;во&shy;ла, они ли&shy;бо пе&shy;ре&shy;ра&shy;ба&shy;ты&shy;ва&shy;ют его в од&shy;но и то же сло&shy;во, ли&shy;бо обе к не&shy;му не&shy;при&shy;ме&shy;ни&shy;мы. </em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Свойство машин Тьюринга называется инвариантным', array('4#invariant')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>ес&shy;ли лю&shy;бые две взаимозаменяемые ма&shy;ши&shy;ны ли&shy;бо обе об&shy;ла&shy;да&shy;ют этим свой&shy;ст&shy;вом, ли&shy;бо обе не об&shy;ла&shy;да&shy;ют.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Свойство машин Тьюринга называется нетривиальным', array('4#netrivial')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>ес&shy;ли су&shy;ще&shy;ст&shy;ву&shy;ют как ма&shy;ши&shy;ны, обладающие этим свой&shy;ст&shy;вом, так и не об&shy;ла&shy;дающие им</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			<p><em>Нормальный алгоритм Маркова</em></p>
			</td>
			<td style="width:451px">
			<p><em>математическое построение, предназначенное для уточнения понятия алгоритм, которое задается алфавитом и нормальной схемой подстановок, выполняемых по заранее определенной схеме.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			<p><em>Тезис Маркова</em></p>
			</td>
			<td style="width:451px">
			<p><em>любой вычислительный процесс можно преобразовать в нормальный алгоритм.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Эффективно перечислимое множество', array('5#EPM')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>множество, элементы которого можно перечислить <u>по алгоритму</u> (пронумеровать натуральным рядом без пропусков и повторений).</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Подмножество В множества А эффективно распознается в А', array('5#5')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>если существует алгоритм, позволяющий однозначно для каждого элемента множества А определить, принадлежит ли данный элемент множеству В или дополнению В до А.</em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Множество (по Тьюрингу)', array('6#6')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это объединение в одно общее объектов, хорошо различимых нашей интуицией или нашей мыслью.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Множество (по Кантору)', array('6#61')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это совокупность объектов безразлично какой природы, неизвестно существующих ли, рассматриваемая как единое целое</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Мощность множества (по Кантору)', array('6#62')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это та общая идея, которая остается у нас, когда мы, мысля об этом множестве, отвлекаемся как от всех свойств его элементов, так и от их порядка.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Мощность множества', array('6#63')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это характеристика, которая объединяет данное множество с другими множествами, применение процедуры сравнения к которым дает основание предполагать, что каждый элемент одного множества имеет парный элемент из другого множества и наоборот.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Конечное множество', array('6#64')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>&nbsp;множество, состоящее из конечного числа элементов, его кардинальное число совпадает с одним из натуральных чисел. </em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Бесконечное множество', array('6#65')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>&nbsp;множество, состоящее из бесконечного числа элементов, его кардинальное число совпадает с одним из трансфинитных чисел. </em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Счетно-бесконечные множества', array('6#66')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>бесконечные множества, равномощные множеству натуральных чисел (их элементы можно пронумеровать натуральными числами без пропусков и повторений).</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Несчетные множества', array('6#67')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>бесконечные множества, не равномощные множеству натуральных чисел</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Счетное множество', array('6#68')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>множество, являющееся конечным или счетно-бесконечным</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Трансфинитное число', array('6#69')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>кардинальное число бесконечного множества</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Множество целых чисел', array('7#70')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>множество, состоящее из натуральных чисел, числа ноль и чисел, построенных на основе натуральных только со знаком &laquo;минус&raquo; (отрицательных чисел).</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Два элемента a и b называют упорядоченной парой', array('7#71')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>если указано, какой их этих элементов первый, а какой второй и при этом ((</em><em>a</em><em>,</em><em>b</em><em>)=(</em><em>c</em><em>,</em><em>d</em><em>))&lt;=&gt;(</em><em>a</em><em>=</em><em>c</em><em>)^(</em><em>b</em><em>=</em><em>d</em><em>). Упорядоченную пару элементов обозначают (</em><em>a</em><em>,</em><em>b</em><em>).</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Упорядоченная n-ка натуральных чисел', array('7#72')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это набор из </em><em>n</em><em> элементов вида (</em><em>m</em><em><sub>1</sub></em><em>, </em><em>m</em><em><sub>2</sub></em><em>, &hellip;, </em><em>m<sub>n</sub></em><em>), где </em><em>m<sub>i</sub></em> <em>&ndash; натуральное число.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Конечные комплексы натуральных чисел', array('7#73')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это элементы вида (</em><em>p</em><em><sub>1</sub></em><em>), (</em><em>p</em><em><sub>1</sub></em><em>, </em><em>p</em><em><sub>2</sub></em><em>), (</em><em>p</em><em><sub>1</sub></em><em>, </em><em>p</em><em><sub>2</sub></em><em>, </em><em>p</em><em><sub>3</sub></em><em>), &hellip;,&nbsp; (</em><em>p</em><em><sub>1</sub></em><em>, </em><em>p</em><em><sub>2</sub></em><em>, &hellip;, </em><em>p<sub>k</sub></em><em>), где </em><em>k</em><em> и </em><em>p<sub>i</sub></em>&nbsp; <em>пробегают все натуральные числа.</em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Рациональное число', array('7#74')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это число вида {!! HTML::image('img/library/Pic/7.1.jpg', 'a picture', array('style' => 'height:52px; width:57px')) !!}, где </em><em>n</em><em> &ndash; целое число, </em><em>m</em><em> &ndash; натуральное число.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Алгебраическое действительное число', array('7#75')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это действительный корень алгебраического уравнения ненулевой степени с рациональными коэффициентами</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Континуум-гипотеза', array('8#80')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>с точностью до эквивалентности, существуют только два типа бесконечных числовых множеств: счетное множество и континуум.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Комплексное число', array('8#81')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>задается парой (</em><em>r</em><em><sub>1</sub></em><em>, </em><em>r</em><em><sub>2</sub></em><em>), где </em><em>r</em><em><sub>1</sub></em><em>, </em><em>r</em><em><sub>2 </sub></em><em>принадлежат множеству&nbsp; действительных чисел</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Иррациональное число', array('8#82')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это действительное число, не являющееся рациональным. </em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Трансцендентное число', array('8#83')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это действительное число, не являющееся алгебраическим. </em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Импредикабельное свойство', array('9#90')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это свойство, которое не применимо само к себе.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			<p><em>Действительное число вычислимо</em></p>
			</td>
			<td style="width:451px">
			<p><em>если существует алгоритм его вычисления с любой степенью точности</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Арифметическая функция', array('10#100')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это функция, определенная на расширенном множестве натуральных чисел </em><em>N</em><em>* и принимающая значения из расширенного множества натуральных чисел </em><em>N</em><em>*..</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Частичная арифметическая функция (ЧАФ)', array('11#110')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это функция, определенная на некотором подмножестве М расширенного множества натуральных чисел </em><em>N</em><em>* и принимающая значения из множества </em><em>N</em><em>*.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Характеристическая функция', array('11#111')) !!} <em> какого-нибудь подмножества А расширенного множества натуральных чисел </em><em>N</em><em>*</em></em></p>
			</td>
			<td style="width:451px">
			<p><em>это функция от одной переменной, равная 1 в точках множества </em><em>A</em><em> и равная 0 в точках, не принадлежащих </em><em>A</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			<p><em>Вычислимая арифметическая функция (ВАФ)</em></p>
			</td>
			<td style="width:451px">
			<p><em>это функция, для которой существует алгоритм вычисления ее значения в любой точке расширенного множества натуральных чисел </em><em>N</em><em>*</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Вычислимая частичная арифметическая функция (ВЧАФ)', array('11#112')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это функция, для которой существует алгоритм вычисления ее значения в любой точке области определенности</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Эффективное&nbsp; распознавание&nbsp; функций', array('11#113')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это процедура, позволяющая при помощи некоторого алгоритма определить, относится ли данная функция к рассматриваемому классу</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Эффективное сравнение арифметических функций', array('11#114')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это процедура, позволяющая при помощи некоторого алгоритма определить, совпадают ли значения функций во всех точках</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Частичная арифметическая функция f называется примитивно-рекурсивной', array('12#120')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>&nbsp;если она может быть получена из простейших функций </em><em>C<sub>q</sub><sup>n</sup></em><em>, </em><em>S</em><em>, </em><em>U<sub>m</sub><sup>n</sup></em><em> конечным числом операций подстановки и примитивной рекурсии (т.е. задана в базисе Клини).</em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Частичная арифметическая функция f называется примитивно-рекурсивной', array('12#121')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>если она может быть получена из </em><em>простейших функций </em><em>C<sub>q</sub><sup>n</sup></em><em>, </em><em>S</em><em>, </em><em>U<sub>m</sub><sup>n</sup></em><em> конечным числом операций подстановки, примитивной рекурсии и минимизации (т.е. задана в расширенном&nbsp; базисе Клини).</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Тезис Черча', array('12#122')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>Класс алгоритмически (или машинно) вычислимых частичных арифметических функций совпадает с классом всех частично рекурсивных функций.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Частичная арифметическая функция f называется общерекурсивной', array('13#130')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>если она может быть получена из из простейших функций </em><em>C<sub>q</sub><sup>n</sup></em><em>, </em><em>S</em><em>, </em><em>U<sub>m</sub><sup>n</sup></em><em> конечным числом операций подстановки, примитивной рекурсии и слабой минимизации</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Кусочно-заданная функция', array('13#131')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>Пусть заданы некоторые функции </em><em>f<sub>i</sub></em><em>(x<sub>1</sub>,.....,x<sub>n</sub>), </em><em>i</em><em>=1,&hellip;,</em><em>s</em><em>+1 и указаны какие то условия </em><em>Pj</em><em>(x<sub>1</sub>,.....,x<sub>n</sub>), </em><em>j</em><em>=1,&hellip;,</em><em>s</em><em>,&nbsp; которые для любого набора чисел x<sub>1</sub>,.....,x<sub>n </sub>могут быть истинными или ложными. Допустим, что ни для одного набора чисел x<sub>1</sub>,.....,x<sub>n </sub>никакие два из упомянутых условий не могут быть одновременно истинными. Функция </em><em>f</em><em>(x<sub>1</sub>,.....,x<sub>n</sub>), заданная схемой:</em></p>

            {!! HTML::image('img/library/Pic/13.9.jpg') !!}

			<p><em>называется кусочно-заданной</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Нерекурсивная функция', array('15#150')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>функция, значение которой нельзя вычислить, несмотря на то, что в&nbsp; данной рассматриваемой точке сама функция определена</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Непримитивно рекурсивная функция', array('15#151')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>функция, являющаяся общерекурсивной, но не принадлежащая к множеству примитивно-рекурсивных функций</em>.</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Временная сложность алгоритма T(x)', array('16#160')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это число его шагов, необходимых для решения данной задачи размера x в худшем случае.</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Пространственная сложность S(x)', array('16#161')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это число единиц памяти, необходимых для решения задачи размера </em><em>x</em><em> в худшем случае. </em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Арифметическая функция f(x) называется функцией одного верхнего порядка с функцией g(x) и записывается &hellip; ', array('16#162')) !!}</em></p>

			<p>&nbsp;</p>
			</td>
			<td style="width:451px">
			<p><em>f(x) = O(g(x)), если существует такое натуральное число c &gt; 0, что, в конце концов (т. е. начиная с некоторого </em><em>x</em><em>) получим&nbsp; f(x) </em><em>&pound;</em><em> c∙g(x).</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Арифметическая функция f(x) называется функцией одного нижнего порядка с функцией g(x) и записывается &hellip;', array('16#163')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>f(x)=о(g(x)), если существует такое c &gt; 0, что в конце концов (начиная с некоторого </em><em>x</em><em>) получим f(x) </em><em>&sup3;</em><em> c</em>∙<em>g(x)</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Арифметическая функция f(x) называется функцией одного порядка с функцией g(x) и записывается &hellip;', array('16#164')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>f(x) = o(g(x)) &amp; f(x) = О(g(x)), если она одного верхнего и одного нижнего порядка с функцией g(x)</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Полиномиальные функции', array('16#165')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это функции одного верхнего порядка с полиномами</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
                <p><em>{!! HTML::linkRoute('lecture', 'Экспоненциальные функции', array('16#166')) !!}</em></p>
			</td>
			<td style="width:451px">
			<p><em>это функции одного нижнего порядка с экспонентой</em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			<p><em>Арифметические функции f(x) и g(x) называются полиномиально-связанными или полиномиально-эквивалентнтными</em></p>
			</td>
			<td style="width:451px">
			<p><em>если существуют такие многочлены P<sub>1</sub>(x) и P<sub>2</sub>(x), что, в конце концов (начиная с некоторого числа) f(x)</em><em>&pound;</em><em>P<sub>1</sub>∙g(x) и g(x)</em><em>&pound;</em><em>P<sub>2</sub>∙f(x)</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			<p><em>Полиномиальный алгоритм</em></p>
			</td>
			<td style="width:451px">
			<p><em>это алгоритм, обе функции сложности которого полиномиальные</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			<p><em>Экспоненциальный алгоритм</em></p>
			</td>
			<td style="width:451px">
			<p><em>это алгоритм, у которого хотя бы одна из двух функций сложности экспоненциальная </em></p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			<p><em>Легкоразрешимая задача</em></p>
			</td>
			<td style="width:451px">
			<p><em>это задача, решаемая полиномиальным алгоритмом</em></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:187px">
			<p><em>Трудноразрешимая задача</em></p>
			</td>
			<td style="width:451px">
			<p><em>это задача, которую нельзя решить полиномиальным алгоритмом</em></p>
			</td>
		</tr>
	</tbody>
</table>

<p style="margin-left:36.0pt">&nbsp;</p>


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
