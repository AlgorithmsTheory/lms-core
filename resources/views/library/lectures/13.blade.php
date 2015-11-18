@extends('templates.base')
@section('head')
    <title>Лекция 13</title>

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
            <li class="active">Лекция 13. Рекурсивные функции: способы их задания.</li>
        </ol>
    </div><!--end .section-header -->
    <div class="section-body">
    </div><!--end .section-body -->
</section>
<div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
<article class="style-default-bright">
<div class="card-body">
<article style="margin-left:10%; margin-right:10%; text-align: justify">

<h3><a name="_Toc209497028">&sect; 13.1. Общерекурсивные функции</a></h3>

<p>&nbsp;Операция минимизации, введенная ранее, ставит в соответствие любой заданной функции <em>f</em> определенную частичную функцию <em>Mf</em><em>.</em> Введем еще одну операцию, которую будем обозначать символом <em>M<sup>l</sup>f</em> и называть <strong>слабой минимизацией</strong>.</p>

<p>По определению положим <em>M<sup>l</sup>f</em><em> = </em><em>Mf</em>, если функция <em>Mf</em> всюду определена.</p>

<p style="margin-left:36.0pt"><em>Частичная арифметическая функция f называется <strong><a name="130">общерекурсивной</a></strong>, если она может быть получена из простейших функций </em><em>C<sub>q</sub><sup>n</sup></em><em>, </em><em>S</em><em>, </em><em>U<sub>m</sub><sup>n</sup></em><em> конечным числом операций подстановки, примитивной рекурсии и <strong>слабой </strong>минимизации.</em></p>

<p>Так как операции подстановки, примитивной рекурсии и слабой минимизации, выполненные над всюду определенными функциями, либо ничего не дают, либо дают снова функции, всюду определенные, то все общерекурсивные функции всюду определенные.</p>

<p>С другой стороны, если результат операции слабой минимизации получен, то он совпадает с результатом обычной минимизации. Поэтому все общерекурсивные функции являются всюду определенными частично-рекурсивными функциями.&nbsp; Обратное тоже верно: каждая всюду определенная частично-рекурсивная функция является общерекурсивной (это утверждение, вообще говоря,&nbsp; требует доказательства, которое в данном курсе не рассматривается).&nbsp;</p>

<center>{!! HTML::image('img/library/Pic/13.1.JPG', 'a picture', array('style' => 'height:126px; width:327px')) !!}</center>
		



<p style="text-align: center;">Рис. 13.1. (1) Отношения между классами рекурсивных функций</p>

<p>Согласно определению, каждая примитивно-рекурсивная функция является общерекурсивной. Классы рекурсивных функций отображены на рисунке 4.2.</p>

<p>Согласно тезису Черча, класс всюду определенно вычислимых числовых функций также будет совпадать с классом&nbsp; общерекурсивных функций.</p>

<p><center>{!! HTML::image('img/library/Pic/13.2.jpg', 'a picture', array('style' => 'height:114px; width:511px')) !!}</center></p>

<p style="text-align: center;">Рис.13.1. (2). Эквивалентность классов функций ВАФ и ОРФ</p>

<h3><a name="_Toc209497029">&sect; 13.2. Задание рекурсивных функций</a> при помощи системы уравнений</h3>

<p>В общем случае<strong> рекурсией</strong> называется такой способ задания функции, при котором значения определяемой функции для произвольных значений аргументов выражаются известным образом через значения определяемой функции для меньших значений аргументов.</p>

<p>Рассмотрим равенство <em>f(х)=</em><em>g</em><em>(</em><em>x</em><em>),</em> где <em>f(х)</em> и <em>g</em><em>(</em><em>x</em><em>)</em>&nbsp; некоторые функции. Когда говорят, что это равенство есть уравнение, то это означает, что равенство рассматривается как неопределенное высказывание, при одних значениях <em>х</em> истинное, при других ложное.&nbsp;</p>

<p>Произвольная система рекурсивных уравнений задает частично &ndash; рекурсивную функцию. Если данная функция определена на всем множестве натуральных чисел, то она будет<strong> <em>общерекурсивной</em>. </strong>Также верно другое утверждение. Функция является общерекурсивной, если она <em>определена</em> посредством ряда уравнений некоторого типа.</p>

<p>Затруднение вызвано тем, что просмотр набора уравнений обычно не убеждает нас в том, что эти уравнения &ldquo;определяют&rdquo; какую-либо функцию вообще. Когда говорится &ldquo;функция&rdquo;, обычно понимается под этим &ldquo;правило, которое каждому значению (или набору из <em>п</em> значений, если мы имеем функцию <em>n</em> переменных) ставит в соответствие результирующее значение&rdquo;. Но в общем случае система уравнений не всегда дает определенное значение.</p>

<p>Например, система уравнений</p>

{!! HTML::image('img/library/Pic/13.3.JPG') !!}

<p>задает некоторую функцию <em>Ф(</em><em>x</em><em>)</em>. Однако ответить на вопрос, <em>определяет</em> ли данная система эту функцию <em>Ф</em> в общем случае невозможно. В данном конкретном случае такие выводы очевидно можно сделать на основе обычного подсчета значений и наших наблюдений касательно поведения функции при росте ее аргумента.</p>

<p>Таблица13.2.(1)</p>

<table border="1" cellpadding="0" cellspacing="0" style="width:554px">
	<tbody>
		<tr>
			<td style="width:34px">
			<p>x =</p>
			</td>
			<td style="width:163px">
			<p>уравнение</p>
			</td>
			<td style="width:67px">
			<p><em>f</em><em>(</em><em>x</em><em>)</em></p>
			</td>
			<td style="width:101px">
			<p>уравнение</p>
			</td>
			<td style="width:78px">
			<p><em>Ф(</em><em>x</em><em>)</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>0</p>
			</td>
			<td style="width:163px">
			<p>&nbsp;</p>
			</td>
			<td style="width:67px">
			<p><em>f</em><em>(0)=3</em></p>
			</td>
			<td style="width:101px">
			<p><em>Ф(0)+0=3</em></p>
			</td>
			<td style="width:78px">
			<p><em>Ф(0)=3</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>1</p>
			</td>
			<td style="width:163px">
			<p><em>f</em><em>(0+1)=</em><em>f</em><em>(0)+2=3+2=5</em></p>
			</td>
			<td style="width:67px">
			<p><em>f</em><em>(1)=5</em></p>
			</td>
			<td style="width:101px">
			<p><em>Ф(1)+3*1=5</em></p>
			</td>
			<td style="width:78px">
			<p><em>Ф(1)=2</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>2</p>
			</td>
			<td style="width:163px">
			<p><em>f</em><em>(1+1)=</em><em>f</em><em>(1)+2=5</em><em>+2=7</em></p>
			</td>
			<td style="width:67px">
			<p><em>f(2)=7</em></p>
			</td>
			<td style="width:101px">
			<p><em>Ф</em><em>(2)+3*2=7</em></p>
			</td>
			<td style="width:78px">
			<p><em>Ф</em><em>(2)</em><em>=</em><em>1</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>3</p>
			</td>
			<td style="width:163px">
			<p><em>f(2+1)=f(2)+2=7+2=9</em></p>
			</td>
			<td style="width:67px">
			<p><em>f(3)=9</em></p>
			</td>
			<td style="width:101px">
			<p><em>Ф</em><em>(3)+3*3=9</em></p>
			</td>
			<td style="width:78px">
			<p><em>Ф</em><em>(3)</em><em>=</em><em>0</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>4</p>
			</td>
			<td style="width:163px">
			<p><em>f(3+1)=f(3)+2=9+2=11</em></p>
			</td>
			<td style="width:67px">
			<p><em>f(4)=11</em></p>
			</td>
			<td style="width:101px">
			<p><em>Ф</em><em>(4)+3*4=11</em></p>
			</td>
			<td style="width:78px">
			<p><em>Ф</em><em>(4) </em>не опред</p>
			</td>
		</tr>
	</tbody>
</table>

<p>Из таблицы видно, что для значений <em>x</em><em>=4</em> и выше значение функции <em>Ф</em> не определено. Т.о. функция <em>Ф(х)</em> &ndash; частично-рекурсивная функция.</p>

<p>Т.о. вполне допустимой является ситуация, когда для некоторых (или даже для всех) точек значение функции не определено&nbsp; &ndash; считается, что в этих точках сама&nbsp; функция не определена. Это явление весьма характерно. Поэтому, делая предположение, что система уравнений действительно определяет общерекурсивную функцию, нужно всегда проявлять осторожность. Обычно требуется дополнительное доказательство этого положения, например, в виде индуктивного доказательства того, что для каждого значения аргумента вычисление завершается выдачей единственного значения.</p>
{!! HTML::image('img/library/Pic/13.4.JPG') !!}

<p>задает функцию <em>Ф(</em><em>x</em><em>)</em>, которая как видно из таблицы и наших наблюдений касательно поведения функции при росте ее аргумента, оказывается <em>всюду</em> определенной. Необходимо обратить особое внимание на то, что такой вывод мы может сделать только при рассмотрении конкретной заданной функции, в общем же случае, как будет показано позднее, невозможно придумать алгоритм, который на основе анализа системы рекурсивных уравнений некоторого типа сможет ответить на вопрос о принадлежности функции к классу общерекурсивных.</p>

<p>В данном случае вычисление значения функции <em>Ф(х)</em> дает следующие результаты (табл. 13.2.(2))</p>

<p>Таблица 13.2.(2)</p>

<table border="1" cellpadding="0" cellspacing="0" style="width:549px">
	<tbody>
		<tr>
			<td style="width:34px">
			<p><em>x</em><em>=</em></p>
			</td>
			<td style="width:165px">
			<p>уравнение</p>
			</td>
			<td style="width:72px">
			<p><em>f</em><em>(</em><em>x</em><em>)</em></p>
			</td>
			<td style="width:96px">
			<p>уравнение</p>
			</td>
			<td style="width:72px">
			<p><em>Ф(</em><em>x</em><em>)</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>0</p>
			</td>
			<td style="width:165px">
			<p>&nbsp;</p>
			</td>
			<td style="width:72px">
			<p><em>f</em><em>(0)=3</em></p>
			</td>
			<td style="width:96px">
			<p><em>Ф(0)+0=3</em></p>
			</td>
			<td style="width:72px">
			<p><em>Ф(0)=3</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>1</p>
			</td>
			<td style="width:165px">
			<p><em>f</em><em>(0+1)=</em><em>f</em><em>(0)+2=3+2=5</em></p>
			</td>
			<td style="width:72px">
			<p><em>f</em><em>(1)=5</em></p>
			</td>
			<td style="width:96px">
			<p><em>Ф(1)+ 1=5</em></p>
			</td>
			<td style="width:72px">
			<p><em>Ф(1)=4</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>2</p>
			</td>
			<td style="width:165px">
			<p><em>f</em><em>(1+1)=</em><em>f</em><em>(1)+2=5+2</em><em>=7</em></p>
			</td>
			<td style="width:72px">
			<p><em>f(2)=7</em></p>
			</td>
			<td style="width:96px">
			<p><em>Ф</em><em>(2)+ 2=7</em></p>
			</td>
			<td style="width:72px">
			<p><em>Ф</em><em>(2)</em><em>=5</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>3</p>
			</td>
			<td style="width:165px">
			<p><em>f(2+1)=f(2)+2=7+2=9</em></p>
			</td>
			<td style="width:72px">
			<p><em>f(3)=9</em></p>
			</td>
			<td style="width:96px">
			<p><em>Ф</em><em>(3)+ 3=9</em></p>
			</td>
			<td style="width:72px">
			<p><em>Ф</em><em>(3)</em><em>=6</em></p>
			</td>
		</tr>
		<tr>
			<td style="width:34px">
			<p>4</p>
			</td>
			<td style="width:165px">
			<p><em>f(3+1)=f(3)+2=9+2=11</em></p>
			</td>
			<td style="width:72px">
			<p><em>f(4)=11</em></p>
			</td>
			<td style="width:96px">
			<p><em>Ф</em><em>(4)+ 4=11</em></p>
			</td>
			<td style="width:72px">
			<p><em>Ф</em><em>(4)</em><em>=7</em></p>
			</td>
		</tr>
	</tbody>
</table>

<p>Очевидно, что разница между значением функции <em>f</em><em>(</em><em>x</em><em>)</em> и собственно значением аргумента <em>х</em> с ростом аргумента только увеличивается,&nbsp; а значит уравнение&nbsp; <em>Ф(</em><em>x</em><em>) +</em><em>x</em><em>=</em><em>f</em><em>(</em><em>x</em><em>)</em> всегда будет иметь единственное решение. Т.о. функция <em>Ф(х)</em> &ndash; общерекурсивная функция.</p>

<p style="margin-left:2.0pt">Система уравнений может быть задана через базисные операции в виде схемы рекурсии. Например, рассмотрим систему уравнений, задающую функцию <em>F</em><em>(</em><em>x</em><em>)</em>:</p>

{!! HTML::image('img/library/Pic/13.5.JPG') !!}
<p style="margin-left:2.0pt">Если раскрыть операции рекурсии и обращения функций, получим:</p>

{!! HTML::image('img/library/Pic/13.6.JPG') !!}

<p>Для <em>х</em><em>=0</em> значение <em>F(x)</em> определено и равно <em>0</em>. Но для <em>х=1</em> наше определение &ldquo;не работает&rdquo;, так как <em>выражение </em><em>F</em><em>(1)=</em><em>m</em><em><sub>y</sub></em><em>[E(y)=1]</em>, означает:</p>

<p>-сначала посмотри, истинно ли <em>Е(0) = 1</em>;</p>

<p>-если нет, посмотри, истинно ли <em>Е(1) = 1</em>;</p>

<p>-если нет, посмотри, истинно ли <em>Е(2) = 1</em>;</p>

<p>-если нет, то ... и т.д.</p>

<p>Вычисление никогда не заканчивается, потому что <em>Е(х)</em> всегда равна нулю, и для <em>F(1)</em> не будет найдено никакого значения.</p>

<p>Вследствие этого при рассмотрении функций, заданных системами рекурсивных уравнений, будем обычно говорить о <em>частично-рекурсивной функции</em>. Когда говорится о частично-рекурсивной функции <em>F</em><em>(</em><em>x</em><em>)</em>, то надо понимать, что может не существовать значения, определенного для некоторого (или даже любого!) значения <em>х.</em> Если <em>F</em><em>(</em><em>x</em><em>) о</em>казывается определенной для всех значений <em>х,</em> то будем называть ее <em>общерекурсивной функцией</em>. Конечно, любая общерекурсивная функция также является частично-рекурсивной.</p>

<p><strong>&sect; 13.3.</strong> <strong>Дополнительные способы задания примитивно-рекурсивных функций</strong></p>

<p>Расширим класс операций, которые, так же как и суперпозиция с примитивной рекурсией, дают в качестве результата примитивно-рекурсивные функции.</p>

<p><strong><u>Т.13.3.(1)Теорема</u></strong></p>

<p><strong>Пусть </strong><strong>n</strong><strong>-местная функция </strong><strong><em>g</em></strong><strong><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,x<sub>n</sub>)</em></strong><strong> примитивно-рекурсивная. Тогда n-местная функция </strong><strong><em>f</em></strong><strong><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>, x<sub>n</sub>),</em></strong><strong> определенная равенством </strong><strong><em>f</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,.....,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em><sub>-1</sub></em></strong><strong><em>, </em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>)=&sum; </em></strong><strong><em>g</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,.....,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em><sub>-1</sub></em></strong><strong><em>, </em></strong><strong><em>i</em></strong><strong><em>)</em></strong><strong>, где&nbsp; </strong><strong><em>i</em></strong>&nbsp; <strong>изменяется от<em> 0 </em>до </strong><strong><em>x<sub>n</sub></em></strong><strong>, также примитивно-рекурсивная.</strong></p>

<p><strong><u>Доказательство</u></strong></p>

<p>Запишем схему примитивной рекурсии по последней переменной:</p>

{!! HTML::image('img/library/Pic/13.7.JPG') !!}

<p>Из этого описания очевидно, что <em>f</em> &ndash; примитивно рекурсивная функция, <strong>Q</strong><strong>.</strong><strong>E</strong><strong>.</strong><strong>D</strong><strong>.</strong></p>

<p><strong><u>Т.13.3.(2)Теорема</u></strong></p>

<p><strong>Пусть </strong><strong>n</strong><strong>-местная функция </strong><strong><em>g</em></strong><strong><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,x<sub>n</sub>)</em></strong><strong> примитивно-рекурсивна. Тогда n-местная функция </strong><strong><em>f</em></strong><strong><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>, x<sub>n</sub>)</em></strong><strong> определенная равенством </strong><strong>f</strong><strong>(</strong><strong>x</strong><strong><sub>1</sub></strong><strong>,.....,</strong><strong>x<sub>n</sub></strong><strong><sub>-1</sub></strong><strong>, </strong><strong>x<sub>n</sub></strong><strong>)=&prod; </strong><strong>g</strong><strong>(</strong><strong>x</strong><strong><sub>1</sub></strong><strong>,.....,</strong><strong>x<sub>n</sub></strong><strong><sub>-1</sub></strong><strong>, </strong><strong>i</strong><strong>), где&nbsp; </strong><strong><em>i</em></strong> <strong>изменяется от <em>0</em> до </strong><strong><em>x<sub>n</sub></em></strong><strong>, также примитивно-рекурсивна.</strong></p>

<p><strong><u>Доказательство</u></strong></p>

<p>Запишем схему примитивной рекурсии по последней переменной:</p>

{!! HTML::image('img/library/Pic/13.8.JPG') !!}

<p>Из этого описания очевидно, что <em>f</em> &ndash; примитивно рекурсивная функция, <strong>Q</strong><strong>.</strong><strong>E</strong><strong>.</strong><strong>D</strong><strong>.</strong></p>

<p>&nbsp;</p>

<p style="margin-left:36.0pt"><em>Пусть заданы некоторые функции </em><em>f<sub>i</sub></em><em>(x<sub>1</sub>,.....,x<sub>n</sub>), </em><em>i</em><em>=1,&hellip;,</em><em>s</em><em>+1 и указаны какие то условия </em><em>Pj</em><em>(x<sub>1</sub>,.....,x<sub>n</sub>), </em><em>j</em><em>=1,&hellip;,</em><em>s</em><em>,&nbsp; которые для любого набора чисел x<sub>1</sub>,.....,x<sub>n </sub>могут быть истинными или ложными. Допустим, что ни для одного набора чисел x<sub>1</sub>,.....,x<sub>n </sub>никакие два из упомянутых условий не могут быть одновременно истинными. Функция </em><em>f</em><em>(x<sub>1</sub>,.....,x<sub>n</sub>), заданная схемой:</em></p>

{!! HTML::image('img/library/Pic/13.9.JPG') !!}
<p style="margin-left:36.0pt"><em>называется <strong><a name="131">кусочно-заданной</a></strong> функцией.</em></p>

<p>Вопрос о том будет ли функция <em>f</em> примитивно-рекурсивной, зависит от природы функций <em>f<sub>i</sub></em> и условий <em>P<sub>i</sub></em><sub>.</sub> Зато для простейшего случая можно доказать очень полезную теорему.</p>

<p><strong><u>Т.13.3.(3)Теорема</u></strong></p>

<p><strong>Пусть заданы </strong><strong>n</strong><strong>-местные примитивно-рекурсивные функции </strong><strong><em>f</em></strong><strong><em><sub>1</sub></em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>), </em></strong><strong><em>f</em></strong><strong><em><sub>2</sub></em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>), &hellip;, </em></strong><strong><em>f<sub>s</sub></em></strong><strong><em><sub>+1</sub></em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>), </em></strong><strong><em>a</em></strong><strong><em><sub>1</sub></em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>), </em></strong><strong><em>a</em></strong><strong><em><sub>2</sub></em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>), &hellip;, </em></strong><strong><em>a<sub>s</sub></em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>),</em></strong><strong> причем ни при каких значениях переменных никакие две из функций </strong><strong><em>a<sub>i</sub></em></strong> <strong>одновременно в <em>0</em> не обращаются. Тогда функция, определенная кусочной схемой </strong></p>

{!! HTML::image('img/library/Pic/13.10.JPG') !!}

<p><strong>будет примитивно-рекурсивной.</strong></p>

<p><strong><u>Доказательство</u></strong></p>

<p>Функцию <em>f</em> можно представить в виде</p>

<p><em>f</em><em> =</em><em>f</em><em><sub>1</sub></em><em>unsga</em><em><sub>1</sub></em><em>+&hellip;+</em><em>f<sub>s</sub>unsga<sub>s</sub></em><em>+</em><em>f<sub>s</sub></em><em><sub>+1</sub></em><em>sg</em><em>(</em><em>a</em><em><sub>1</sub></em><em>∙</em><em>a</em><em><sub>2</sub></em><em>∙..∙</em><em>a<sub>s</sub></em><em>)</em></p>

<p>Все примененные функции &ndash; примитивно рекурсивные, следовательно, <em>f</em> &ndash; примитивно рекурсивная функция, <strong>Q</strong><strong>.</strong><strong>E</strong><strong>.</strong><strong>D</strong><strong>.</strong></p>

<p>В данной теореме рассмотрены простейшие случаи, когда все условия <em>p<sub>i</sub></em> имеют вид <em>a<sub>i</sub></em><em>=0</em>. На самом деле условия могут быть сформулированы иначе, однако с помощью функции псевдоразности их можно преобразовать к виду, указанному в теореме.</p>

<p>Например,</p>

<p><em>a<sub>i</sub></em><em>=</em><em>b<sub>i</sub></em>&nbsp; эквивалентно <em>|</em><em>a<sub>i</sub></em><em>&divide;</em><em>b<sub>i</sub></em><em>|=0,</em></p>

<p><em>a<sub>i</sub></em><em>&le;</em><em>b<sub>i</sub></em> &nbsp;эквивалентно&nbsp; <em>a<sub>i</sub></em><em>&divide;</em><em>b<sub>i</sub></em><em>=0</em>,</p>

<p><em>a<sub>i</sub>&lt;b<sub>i</sub></em>&nbsp; эквивалентно <em>unsg(b<sub>i</sub>&divide;a<sub>i</sub>)=0</em>.</p>

<p>Таким образом, теорема оказывается справедливой и в этих случаях.</p>

<h3>&sect; 13.4. Мажорируемые неявные функции</h3>

<p>Как уже говорилось ранее, большой ошибкой было бы думать, что функция, выраженная при помощи оператора минимизации, однозначно является непримитивно-рекурсивной. В ряде случаев использование оператора минимизации есть не более чем удобный способ задания процедуры вычисления, позволяющий обойти определенные формальные трудности. Как мы покажем ниже, иногда пусть и более сложным образом, но все же удается заменить процедуру поиска минимально возможного решения для уравнения, задающего всюду определенную функцию.</p>

<p>Рассмотрим уравнение <em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>y</em><em>)=0</em>, левая часть которого есть всюду определенная функция. Допустим, для каждого <em>x</em><em><sub>1</sub></em><em>,&hellip;</em><em>x<sub>n</sub></em>&nbsp; уравнение имеет единственное решение <em>y</em>. Тогда это решение будет однозначной всюду определенной функцией от <em>x</em><em><sub>1</sub></em><em>,&hellip;</em><em>x<sub>n</sub></em>. Актуален вопрос: будет ли функция <em>y</em><em>=</em><em>f</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>)</em> &ndash; примитивно-рекурсивной, если левая часть уравнения, а именно <em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>,</em><em>y</em><em>)</em>&nbsp; есть примитивно рекурсивная функция.</p>

<p>В общем случае это не так. Зато в некоторых отдельных случаях ответ будет положительным.</p>

<p>&nbsp;</p>

<p><strong><u>Т.13.4.(1)Теорема о мажорируемых неявных функциях</u></strong></p>

<p><strong>Пусть </strong><strong><em>g</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>, </em></strong><strong><em>y</em></strong><strong><em>), </em></strong><strong><em>a</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>)</em></strong><strong> &ndash; такие примитивно-рекурсивные функции, что уравнение </strong><strong><em>g</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>, </em></strong><strong><em>y</em></strong><strong><em>)=0 </em></strong><strong>для каждых </strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong> имеет по меньшей мере одно решение и </strong><strong><em>&mu;<sub>y</sub></em></strong><strong><em>(</em></strong><strong><em>g</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>, </em></strong><strong><em>y</em></strong><strong><em>)=0) &le; </em></strong><strong><em>a</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>)</em></strong><strong> для любых </strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong> <strong>. Тогда функция </strong><strong><em>f</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>)= </em></strong><strong><em>&mu;<sub>y</sub></em></strong><strong><em>(</em></strong><strong><em>g</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>, </em></strong><strong><em>y</em></strong><strong><em>)=0)</em></strong><strong> также примитивно рекурсивна.</strong></p>

<p><strong><u>Доказательство</u></strong></p>

<p>Фиксируем какие-нибудь значения <em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em> и пусть <em>b</em><em>= </em><em>&mu;<sub>y</sub></em><em>(</em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>y</em><em>)=0)</em>. Рассмотрим последовательность произведений:</p>

<p><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, 0)</em></p>

<p><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, 0) ∙ </em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, 1)</em></p>

<p><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, 0) ∙ </em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, 1) ∙ </em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, 2)</em></p>

<p><em>&hellip;</em></p>

<p><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, 0) ∙ </em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, 1) ∙ </em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, 2) ∙&hellip;∙ </em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>i</em><em>)</em></p>

<p><em>&hellip;</em></p>

<p>Так как <em>y</em><em>=</em><em>b</em> есть наименьшее решение уравнения <em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>y</em><em>)=0</em>, то первые <em>b</em>&nbsp; членов этой последовательности нулю точно не равны, зато все остальные содержат равный нулю сомножитель <em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>b</em><em>)</em> и потому равны нулю.</p>

<p>Из условия <em>&mu;<sub>y</sub></em><em>(</em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>y</em><em>)=0) &le; </em><em>a</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>)</em> вытекает что</p>

{!! HTML::image('img/library/Pic/13.11.JPG') !!}

<p>Введем примитивно-рекурсивную функцию:</p>

{!! HTML::image('img/library/Pic/13.12.JPG') !!}

<p>Теперь получим:</p>

{!! HTML::image('img/library/Pic/13.13.JPG') !!}

<p>В силу теорем о сложении и мультиплицировании&nbsp; <em>f</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>)</em> &ndash; примитивно-рекурсивная функция, <strong>Q</strong><strong>.</strong><strong>E</strong><strong>.</strong><strong>D</strong><strong>.</strong></p>


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