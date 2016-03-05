@extends('templates.base')
@section('head')
    <title>Лекция 12</title>

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
            <li class="active">Лекция 12. Рекурсивные функции.</li>
        </ol>
    </div><!--end .section-header -->
    <div class="section-body">
    </div><!--end .section-body -->
</section>
<div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
<article class="style-default-bright">
<div class="card-body">
<article style="margin-left:10%; margin-right:10%; text-align: justify">

    <a name="3.1"></a>

<h3>&sect; 12.1. Роль рекурсивных функций</h3>

<p>&nbsp;Задача точного определения понятия алгоритма была полностью решена в 30-х годах XX века в двух формах: на основе описания алгоритмического процесса и на основе понятия рекурсивной функции.</p>

<p> Первый подход подробно описан в первых лекциях и заключается в том, что был сконструирован формальный автомат, способный осуществлять ограниченный набор строго определённых элементарных операций (машина Тьюринга). Алгоритмом стали называть конечную последовательность таких операций и постулировали предложение, что любой интуитивный алгоритм является алгоритмом и в сформулированном выше смысле. То есть для каждого алгоритма можно подобрать реализующую его машину Тьюринга.</p>

<p> Развитие этой теории позволило строго доказать алгоритмическую неразрешимость ряда важных математических проблем. Однако её существенным недостатком является невозможность реализации такой полезной конструкции как рекурсия.</p>

<p> Этого недостатка лишён другой подход к формализации понятия алгоритма, развитый Гёделем и Чёрчем. Здесь теория построена на основе широкого класса так называемых частично рекурсивных функций.</p>

<p> Замечателен тот факт, что оба данных подхода, а также другие подходы (в т.ч. алгоритмы Маркова, машины Поста) приводят к одному и тому же классу алгоритмически вычислимых функций. Поэтому далее представляется целесообразным рассмотреть теорию частично рекурсивных функций Чёрча, так как она позволяет доказать не только алгоритмическую разрешимость конкретной задачи, но и существование для неё рекурсивного алгоритма.</p>

<p>Важно отметить, что рекурсия сама по себе не является алгоритмом, она является методом построения алгоритмов. Ее очень удобно применять (но не обязательно эффективно) в тех случаях, когда можно выделить самоподобие задачи, т.е. свести вычисление задачи некоторой размерности N к вычислению аналогичных задач меньшей размерности.</p>

<p>При этом, если получается сделать алгоритм без применения рекурсии, то, скорее всего, им и надо воспользоваться. Рекурсивные вызовы подпрограмм имеют свойство решать одну и ту же задачу бесчисленное количество раз (во время повторов), что значительно сказывается на времени.</p>

<p>Кроме того, рекурсивные функции очень опасны. Несмотря на то, что существует множество задач, на решение которых прямо напрашивается рекурсия, не стоит сразу же бросаться реализовывать рекурсивные вызовы. Вполне вероятно, что все это обернется либо большими и неоправданными расходами оперативной памяти, либо будет очень медленно работать.</p>

<p>Широкий класс частично-рекурсивных функций, как будет показано далее, можно детализировать, строго выделив довольно интересные по своим свойствам подклассы примитивно-рекурсивных и общерекурсивных функций. Гипотеза Черча (о тождественности класса общерекурсивных функций и класса всюду определенных вычислимых функций) и гипотеза Клини (о тождественности класса&nbsp; частичных функций, вычисляемых посредством алгоритмов, и класса частично-рекурсивных функций) хотя и являются недоказуемыми, позволили придать необходимую точность формулировкам алгоритмических проблем и в ряде случаев сделать возможным доказательство их неразрешимости.</p>



<p style="margin-left:36.0pt"><strong><u><a name="122">Тезис Черча.</a></u></strong> <em>Класс алгоритмически (или машинно) вычислимых частичных арифметических функций совпадает с классом всех частично рекурсивных функций.</em></p>

<p>&nbsp;</p>

<p>Иными словами, &nbsp;частичная арифметическая функция, вычислимая в общем смысле, есть суть частично рекурсивная функция. Это не строгое определение, это вывод на уровне тезиса (не доказанное, но и не опровергнутое утверждение).</p>

<p><center>{!! HTML::image('img/library/Pic/12.1.jpg', 'a picture', array('style' => 'height:110px; width:511px')) !!}</p>

<p>&nbsp;</p>

<p>Рис. 12.1. Эквивалентность классов функций ВЧАФ и ЧРФ</p>
</center>

<h3>&sect; 12.2. Примитивно-рекурсивные функции</h3>

<p>Класс примитивно-рекурсивных функций определяется путем указания конкретных исходных функций (они называются базисными) и фиксированного множества операций над ними, применяемых для получения новых функций из ранее заданных.</p>

<p>В качестве базисных функций обычно берутся следующие:</p>

<ul>
	<li>Функция <strong>следования</strong>;</li>
	<li>Функция <strong>тождества</strong> (функция проекции, или функция выбора аргументов);</li>
	<li>Функция &nbsp;<strong>константы</strong>.</li>
</ul>

<p>Допустимыми операциями над функциями являются операции суперпозиции (подстановки) и примитивной рекурсии.</p>

<p>&nbsp;</p>

<p style="margin-left:36.0pt"><em>Частичная арифметическая функция f называется <strong><a name="120">примитивно-рекурсивной</a>,</strong> если она может быть получена из простейших функций </em><em>C<sub>q</sub><sup>n</sup></em><em>, </em><em>S</em><em>, </em><em>U<sub>m</sub><sup>n</sup></em><em> конечным числом операций подстановки и примитивной рекурсии (т.е. задана в базисе Клини).</em></p>

<p>&nbsp;</p>

<p>Т.о. <em>базис Клини</em>&nbsp; состоит из:</p>

<ul>
	<li>трех&nbsp; простых функций;</li>
	<li>двух разрешенных операций.</li>
</ul>

<p> Рассмотрим сначала функции.</p>

<p>1) функция &ndash; <strong>следование:</strong>&nbsp;&nbsp; <em>S</em><em>(</em><em>x</em><em>) = </em><em>x</em><em>&#39; = </em><em>x</em><em>+1</em>, где x&rsquo; &ndash; число, непосредственно следующее за натуральным числом х. Например, 0&rsquo; = 1, 1&rsquo; = 2, &hellip; и т.д.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<p>2) функция - <strong>тождество</strong>:&nbsp; {!! HTML::image('img/library/Pic/12.2.jpg', 'a picture', array('style' => 'height:32px; width:145px')) !!}, где n &ndash; кол-во переменных, а i &ndash; номер переменной, по которой берется тождество. Функция тождества &ndash; функция, равная одному из своих аргументов. Например, {!! HTML::image('img/library/Pic/12.3.jpg', 'a picture', array('style' => 'height:30px; width:123px')) !!}.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<p>3) функция - <strong>константа</strong>: {!! HTML::image('img/library/Pic/12.4.jpg', 'a picture', array('style' => 'height:33px; width:140px')) !!}<strong>, </strong>&nbsp;где n &ndash; число переменных, q &ndash; значение, которое принимает функция. Функция константа принимает всюду одно значение. Например, C<sub>2</sub><sup>3</sup>(16,9,10)=2.</p>

<p>Далее рассмотрим операции.</p>

<p>1) операция<strong> примитивной рекурсии </strong><strong>R</strong></p>

<p>Если мы имеем функцию одной переменной <em>f</em><em>(</em><em>x</em><em>)</em>, то схема рекурсии называется <u>&laquo;рекурсия без параметров&raquo;</u> и задается системой уравнений<strong>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>

<p><strong><em>f</em></strong><strong><em> (0) = </em></strong><strong><em>q</em></strong></p>

<p><strong><em>f</em></strong><strong><em> (</em></strong><strong><em>x</em></strong><strong><em>&#39;) = </em></strong><em>&chi;</em><strong><em> (</em></strong><strong><em>f</em></strong><strong><em> (</em></strong><strong><em>x</em></strong><strong><em>), </em></strong><strong><em>x</em></strong><strong><em>)</em></strong></p>

<p>Функция, заданная такими уравнениями, кратко задается схемой вида <strong>R<sub>q</sub></strong><strong> ( </strong>&chi;<strong> ). </strong>Поскольку вид системы уравнений (и способ задания трех разрешенных функций)&nbsp; строго определен, то схема является однозначной.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<p>Если мы имеем функцию нескольких переменных <em>f</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,</em><em>x</em><em><sub>2</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>)</em>, то схема рекурсии называется <u>&laquo;рекурсия с параметрами&raquo;</u> и задается системой уравнений<strong>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<p><strong><em>f</em></strong><strong><em> (0, </em></strong><strong><em>x</em></strong><strong><em><sub>2</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>) = </em></strong><strong><em>&Psi;</em></strong><strong><em> (</em></strong><strong><em>x</em></strong><strong><em><sub>2</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>)</em></strong><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></p>

<p><strong><em>f</em></strong><strong><em> (</em></strong><strong><em>x</em></strong><strong><em>&#39;<sub>1</sub>, </em></strong><strong><em>x</em></strong><strong><em><sub>2</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>) = </em></strong><em>&chi;</em> <strong><em>(</em></strong><strong><em>f</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>), </em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x<sub>n</sub></em></strong><strong><em>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </em></strong></p>

<p>Функция, заданная такими уравнениями, кратко задается схемой вида <strong>R<sup>n</sup></strong> <strong>(</strong><strong>&Psi;</strong><strong>, </strong>&chi;)</p>

<p>2) операция <strong>подстановки (суперпозиции) </strong><strong>S</strong><strong>:&nbsp; </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<p>Пусть заданы m каких либо частичных арифметических функций <strong><em>f</em></strong><strong><em><sub>1</sub></em></strong><strong><em>, </em></strong><strong><em>f</em></strong><strong><em><sub>2</sub></em></strong><strong><em>,&hellip;</em></strong><strong><em>f<sub>m</sub></em></strong> от одного и того же числа&nbsp; n переменных,&nbsp; определенных на множестве А со значениями в множестве В. Пусть на множестве В задана частичная функция Ф от n переменных, значения которой принадлежат множеству С. Введем теперь частичную функцию <strong><em>g</em></strong> от <strong>n</strong>&nbsp; переменных, определенную на А со значениями в С, полагая по определению для произвольных <strong>x</strong><strong><sub>1</sub></strong><strong>,&hellip;,</strong><strong>x</strong> <strong><sub>n</sub></strong>.</p>

<p><strong><em>g</em></strong><strong><em>(</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x</em></strong> <strong><em><sub>n</sub></em></strong><strong><em>) = </em></strong><strong><em>&Phi;</em></strong><strong><em> (</em></strong><strong><em>f</em></strong><strong><em><sub>1</sub></em></strong><strong><em> (</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x</em></strong> <strong><em><sub>n</sub></em></strong><strong><em>), </em></strong><strong><em>f</em></strong><strong><em><sub>2</sub></em></strong><strong><em> (</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x</em></strong> <strong><em><sub>n</sub></em></strong><strong><em>),&hellip;, </em></strong><strong><em>f</em></strong> <strong><em><sub>m</sub></em></strong><strong><em> (</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x</em></strong> <strong><em><sub>n</sub></em></strong> <strong><em>))</em></strong></p>

<p>Говорят, что функция <strong><em>g</em></strong> получается операцией суперпозиции или подстановки из функций <strong><em>f</em></strong><strong><em><sub>1</sub></em></strong><strong><em>, </em></strong><strong><em>f</em></strong><strong><em><sub>2</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>f<sub>m</sub></em></strong><strong>. </strong>Обозначается эта операция буквой <strong>S</strong> с двумя индексами: верхний (n) показывает от скольких переменных зависят внутренние функции <strong><em>f<sub>i</sub></em></strong><strong><em> (</em></strong><strong><em>x</em></strong><strong><em><sub>1</sub></em></strong><strong><em>,&hellip;, </em></strong><strong><em>x</em></strong> <strong><em><sub>n</sub></em></strong><strong><em>)</em></strong><strong>, </strong>а нижний (m) &ndash; количество самих функций <strong><em>f</em></strong><strong><em><sub>1</sub></em></strong><strong><em>, </em></strong><strong><em>f</em></strong><strong><em><sub>2</sub></em></strong><strong><em>,&hellip;,</em></strong><strong><em>f<sub>m</sub></em></strong><strong><em>.</em></strong></p>

{!! HTML::image('img/library/Pic/12.5.JPG') !!}

<p>При этом функция&nbsp; <strong><em>Ф</em></strong> при подсчете внутренних функций не учитывается.</p>



<h3>&sect; 12.3. Частично рекурсивные функции</h3>

<p>Класс частично-рекурсивных функций определяется путем указания конкретных исходных функций и фиксированного множества операций получения новых функций из ранее заданных.</p>

<p>В качестве базисных функций обычно берутся следующие:</p>

<ul>
	<li>Функция <strong>следования</strong>;</li>
	<li>Функция <strong>тождества</strong> (функция проекции, или функция выбора аргументов);</li>
	<li>Функция &nbsp;<strong>константы</strong>.&nbsp;</li>
</ul>

<p>Допустимыми операциями над функциями являются операции суперпозиции (подстановки), примитивной рекурсии и минимизации.</p>

<p style="margin-left:36.0pt"><em>Функция называется<strong> <a name="121">частично-рекурсивной</a></strong>, если она может быть получена из </em><em>простейших функций </em><em>C<sub>q</sub><sup>n</sup></em><em>, </em><em>S</em><em>, </em><em>U<sub>m</sub><sup>n</sup></em><em> конечным числом операций подстановки, примитивной рекурсии и минимизации (т.е. задана в расширенном &nbsp;базисе Клини).</em></p>

<p>Т.о. <em>расширенный базис Клини</em>&nbsp; состоит из:</p>

<ul>
	<li>трех&nbsp; простых функций (аналогичны стандартному базису Клини);</li>
	<li>трех разрешенных операций (две из них аналогичны стандартному базису Клини, третья называется операцией минимизации).</li>
</ul>

<p><strong><u>Оператор минимизации</u></strong></p>

<p>Пусть имеется функция&nbsp; <em>f(x<sub>1</sub>,&hellip;.x<sub>n</sub>)</em>, принадлежащая множеству частичных арифметических функций (ЧАФ). Пусть существует какой то механизм ее вычисления, причем значение функции не определено тогда и только тогда, когда этот механизм работает бесконечно, не выдавая никакого определенного результата.</p>

<p>Фиксируем какие-нибудь значения <em>x<sub>1</sub>,......,x<sub>n-1</sub></em> для первых <em>n-1</em> аргументов функции <em>f </em>и рассмотрим уравнение: <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,y)=x<sub>n</sub>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</em></p>

<p>Чтобы найти решение <em>y</em> (натуральное) этого уравнения, будем вычислять при помощи указанного выше &quot;механизма&quot; последовательно значения <em>f(x<sub>1</sub>,...,x<sub>n-1</sub>,</em><em>y</em><em>)</em> для y=0,1,2,... Наименьшее значение a, для которого получится <em>f</em><em>(x<sub>1</sub>,...x<sub>n-1</sub>,a)=x<sub>n</sub></em>, обозначим через</p>

<p><em>&mu;<sub>y</sub>(f(x<sub>1</sub>,...,x<sub>n-1</sub>,y)=x<sub>n</sub>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </em></p>

<p>Описанный процесс нахождения выражения <em>&mu;<sub>y</sub>(f(x<sub>1</sub>,...,x<sub>n-1</sub>,y)=x<sub>n</sub>)</em> будет продолжаться бесконечно в следующих случаях:</p>

<ul>
	<li>Значение <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,0)</em> не определено;</li>
	<li>Значения <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,y)</em> для <em>y=0,1,...,a-1</em> определены, но отличны от <em>x<sub>n</sub></em>, а значение <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,</em><em>a</em><em>)</em> &ndash; не определено;</li>
	<li>Значения <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,y)</em> определены для всех <em>y=0,1,2,...</em> и отличны от <em>x<sub>n</sub></em>.</li>
</ul>

<p>Во всех этих случаях значение выражения <em>&mu;<sub>y</sub>(f(x<sub>1</sub>,...,x<sub>n-1</sub>,y)=x<sub>n</sub>)</em> считается неопределенным. В остальных случаях описанный процесс обрывается и дает наименьшее решение <em>y=a</em> уравнения <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,y)=x<sub>n</sub></em><sub>.</sub>. Это&nbsp; решение, как сказано, и будет значением выражения <em>&mu;<sub>y</sub>(f(x<sub>1</sub>,...,x<sub>n-1</sub>,y)=x<sub>n</sub>)</em>.</p>

<p>Например, для функции разности <em>f</em><em>(</em><em>x</em><em>,</em><em>y</em><em>)=x-y</em> в соответствии с указанным смыслом символа &mu;, для всех x,y имеем:</p>

<p><em>f(x,y)=x-y=</em><em>&mu;</em><em><sub>z</sub></em><em>(y+z=x)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></p>

<p>Подсчет значений функции <em>f</em><em>(</em><em>x</em><em>,</em><em>y</em><em>)=x-y</em> в этом случае будет проходить по двум сценариям.</p>

<p><em>Пример 1</em>: Пусть х=5, у=3. Последовательно, начиная с z=0, перебираем возможные значения для нахождения <em>&mu;<sub>z</sub>(y+z=x)</em>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<ul>
	<li>при z=0 получим выражение 3+0=5, его значение &laquo;ложь&raquo;;</li>
</ul>

<ul>
	<li>при z=1 получим выражение 3+1=5, его значение &laquo;ложь&raquo;;</li>
</ul>

<ul>
	<li>при z=2 получим выражение 3+2=5, его значение &laquo;истина&raquo;, следовательно, процесс обрывается, и получаем результат: <em>&mu;<sub>z</sub>(3+z=5)=2.</em></li>
</ul>

<p>Т.о., не умея производить операцию вычитания (которая отсутствует в базисе Клини), мы смогли посчитать значение частичной функции <em>f</em><em>(</em><em>x</em><em>,</em><em>y</em><em>)=x-y</em> для двух заданных значений аргументов.</p>

<p><em>Пример 2</em>: Пусть х=3, у=5. Последовательно, начиная с z=0, перебираем возможные значения для нахождения <em>&mu;<sub>z</sub>(y+z=x)</em>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<ul>
	<li>при z=0 получим выражение 5+0=3, его значение &laquo;ложь&raquo;;</li>
	<li>при z=1 получим выражение 5+1=3, его значение &laquo;ложь&raquo;;</li>
	<li>при z=2 получим выражение 5+2=3, его значение &laquo;ложь&raquo;;</li>
</ul>

<p>и т.д. &ndash; т.е.&nbsp; при увеличении z ситуация, при которой выражение <em>5+z=3</em> будет иметь значение &laquo;истина&raquo;, так и не наступит, а значит значение функции <em>&mu;<sub>z</sub>(5+z=3)</em> так и не будет найдено.</p>

<p>Пример 2 &ndash; это иллюстрация случая, при котором оператор минимизации не дает результата именно тогда, когда такой результат не может быть получен в принципе, по той причине, что в заданной точке функция действительно не определена. Это третий случай, в котором процесс поиска выражения <em>&mu;<sub>y</sub>(f(x<sub>1</sub>,...,x<sub>n-1</sub>,y)=x<sub>n</sub>)</em> продолжается бесконечно.</p>

<p>Напротив, значение выражения <em>&mu;<sub>y</sub>((y+1)(y-(x+1))=0)</em> не определено, так как уже при <em>y</em><em>=0</em> значение терма <em>1∙(0-(x+1))</em> для любого х не определено. В то же время уравнение <em>(y+1)(y-(x+1))=0</em> имеет решение <em>y=x+1</em>, но оно не совпадает со значением выражения <em>&mu;<sub>y</sub>((y+1)(y-(x+1))=0).</em></p>

<p>Этот пример показывает, что для частичных функций <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,y)</em>&nbsp; выражение <em>&mu;<sub>y</sub>(f(x<sub>1</sub>,...,x<sub>n-1</sub>,y)=x<sub>n</sub>)</em>, строго говоря, не есть наименьшее решение уравнения <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,y)=x<sub>n</sub>.</em> Если же функция <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,y)</em>&nbsp; всюду определенная и уравнение <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,y)=x<sub>n</sub></em>&nbsp; имеет решения, то <em>&mu;<sub>y</sub>(f(x<sub>1</sub>,...,x<sub>n-1</sub>,y)=x<sub>n</sub>) </em>есть наименьшее решение для этого уравнения. Отсюда возникает закономерное желание использовать под оператором минимизации только всюду определенные функции. Наилучший способ убедиться в том, что функция всюду определена &ndash; использовать заведомо примитивно рекурсивные функции (или функции, примитивная рекурсивность которых уже доказана ранее или вытекает из способа их задания). В этом случае значения <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n</sub>)</em> будет неопределенно только в одном из трех случаев, а именно если значения <em>f</em><em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,y)</em> определены для всех <em>y=0,1,2,...</em> и отличны от <em>x<sub>n</sub></em>. Для этого имеющуюся функцию нужно преобразовать таким образом (путем переноса слагаемых, умножения обеих частей, и т.д.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ) чтобы по обе стороны равенства стояли примитивно рекурсивные (а значит всюду определенные) выражения. В общем виде, под оператором минимизации получим некое рекурсивное уравнение, части которого зависят от переменных <em>(x<sub>1</sub>,.....,x<sub>n-1</sub>,x<sub>n</sub>,y)</em>. Это уравнение принимает значение &laquo;истина&raquo; или &laquo;ложь&raquo; при последовательно выбираемых значениях параметра y.</p>

<p>Итак, для того, чтобы задать частично-рекурсивную функцию в виде элементарной схемы ее вычисления, необходимо расширить введенный ранее базис Клини за счет появления новой операции: операции минимизации. Здесь важно понимать, что в расширенном базисе Клини в итоге могут оказаться заданы также и примитивно-рекурсивные функции &ndash; но для примитивно-рекурсивных функций использование этого оператора, по сути, является избыточным.</p>


<p><em>Пример 3.</em> Нигде неопределенная функция {!! HTML::image('img/library/Pic/12.6.jpg', 'a picture', array('style' => 'height:27px; width:113px')) !!}. Построим рекурсивное уравнение:</p>

<p>{!! HTML::image('img/library/Pic/12.7.jpg', 'a picture', array('style' => 'height:28px; width:198px')) !!}. Результат операции минимизации не определен даже для точки <em>х=0</em>.</p>

<p><em>Пример 4.</em> Функция, определенная в одной точке, {!! HTML::image('img/library/Pic/12.8.jpg', 'a picture', array('style' => 'height:27px; width:88px')) !!}. Построим рекурсивное уравнение: {!! HTML::image('img/library/Pic/12.9.jpg', 'a picture', array('style' => 'height:28px; width:173px')) !!}. Результат операции минимизации определен только для точки <em>х=0</em>, при остальных значениях <em>x</em> вычисление (подбор нужного значения <em>z</em>) никогда не будет закончено.</p>

<p><strong><u>Обращение функций</u></strong></p>

<p>Функция <em>g</em><em>(</em><em>x</em><em>)</em> называется <strong><em>обращением</em></strong> функции <em>f</em><em>(</em><em>x</em><em>), если </em><em>g</em><em>(</em><em>x</em><em>) =&mu;</em><em><sub>y</sub></em><em>(</em><em>f</em><em>(</em><em>y</em><em>)=x)</em> . Для указания на обращение функции <em>f</em><em>(</em><em>x</em><em>) </em>часто используется запись <em>f</em> <em><sup>-1</sup></em><em>(x).</em></p>


<p><em>Пример 1.</em> &nbsp;Для знаковой функции <em>sg</em><em>(</em><em>x</em><em>)</em> обращение будет выглядеть следующим образом:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
{!! HTML::image('img/library/Pic/12.10.JPG') !!}

<p><em>Пример 2.</em> &nbsp;Для функции следования <em>s</em><em>(</em><em>x</em><em>)</em> обращение будет выглядеть следующим образом:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

{!! HTML::image('img/library/Pic/12.11.JPG') !!}


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