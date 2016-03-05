@extends('templates.base')
@section('head')
    <title>Лекция 10</title>

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
                <li class="active">Лекция 10.</li>
            </ol>
        </div><!--end .section-header -->
        <div class="section-body">
        </div><!--end .section-body -->
    </section>
    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
        <article class="style-default-bright">
            <div class="card-body">
                <article style="margin-left:10%; margin-right:10%; text-align: justify">
                    <a name="2.6"></a>
                    <a name="2.8"></a>
		<p>Лекция 10. Арифметические функции.</p>

<p><strong style="line-height:1.6em">&sect; 10.1.</strong><strong style="line-height:1.6em"> Арифметические функции</strong></p>

<p><span style="line-height:1.6em">Расширенное множество натуральных чисел, помимо обычного множества натуральных чисел, включает также число ноль (это множество обозначается N*).</span></p>

<p style="margin-left:36.0pt"><strong style="line-height:1.6em"><em><a name="100">Арифметическая функция </a></em></strong><em style="line-height:1.6em">&ndash; функция, определенная на РАСШИРЕННОМ множестве натуральных чисел и принимающая значения из РАСШИРЕННОГО множества натуральных чисел.</em></p>

<p><strong style="line-height:1.6em"><u>Т.10.1. Теорема</u></strong></p>

<p><strong>Множество арифметических функций </strong><strong>n</strong><strong>-переменных несчетно. </strong></p>

<p style="margin-left:45.0pt"><strong><u>Доказательство</u></strong></p>

<p>Для доказательства несчетности множества достаточно доказать несчетность какого-нибудь его подмножества. Рассмотрим арифметические функции одной переменной вида <em>f</em> <sub>i</sub>(x). Эти арифметические функции одной переменной образуют подмножество множества арифметических функций <em>n</em> переменных.</p>

<p>Предположим противное. Пусть арифметических функций одной переменной счетное множество, т.е. их можно перечислить. Тогда их можно расположить в виде бесконечной последовательности &nbsp;<em>f</em><em><sub>0</sub></em><em>(</em><em>x</em><em>)</em>, <em>f</em><em><sub>1</sub></em><em>(</em><em>x</em><em>)</em>, <em>f</em><em><sub>2</sub></em><em>(</em><em>x</em><em>)</em>, &hellip; , <em>f<sub>n</sub></em><em>(</em><em>x</em><em>)</em>,&hellip;</p>

<p>Построим новую функцию <em>g</em><em>(</em><em>x</em><em>)=</em><em>f<sub>x</sub></em><em>(</em><em>x</em><em>)+1.</em></p>

<p>Это так называемая диагональная функция, например:</p>

<p><em>g</em><em>(0)= </em><em>f</em><em><sub>0</sub></em><em>(0)+1,&nbsp; </em><em>g</em><em>(1)= </em><em>f</em><em><sub>1</sub></em><em>(1)+1,&nbsp; </em><em>g</em><em>(2)= </em><em>f</em><em><sub>2</sub></em><em>(2)+1, &hellip;</em></p>

<p><em>g</em><em>(</em><em>x</em><em>)</em> отлична от всех перечисленных функций, т.к. от каждой из функций она отличается &nbsp;хотя бы в одной точке. Например, от функции <em>f</em><em><sub>0</sub></em><em>(</em><em>x</em><em>)</em> функция <em>g</em><em>(</em><em>x</em><em>)</em> отличается в точке х=0, от функции <em>f</em><em><sub> 1</sub></em><em>(</em><em>x</em><em>)</em> функция <em>g</em><em>(</em><em>x</em><em>)</em> отличается в точке <em>х</em>=1 и т.д.&nbsp; Однако по построению <em>g</em><em>(</em><em>x</em><em>)</em> принадлежит множеству арифметических функций одной переменной, значит должна быть в списке перечисления <em>f<sub>i</sub></em><em>(</em><em>x</em><em>)</em>, т.е. совпадать с одной из перечисленных функций. Получили противоречие, следовательно, исходное предположение неверно, и функций одной переменной несчетное множество.</p>

<p>Поскольку множество арифметических функций одной переменной является подмножеством множества арифметических функций <em>n</em> переменных, то значит множество арифметических функций <em>n</em> переменных <strong><em>несчетно</em></strong>, <strong>Q.E.D.</strong></p>

<p><strong style="line-height:1.6em">&sect; 10.2.</strong><strong style="line-height:1.6em"> Вычислимые арифметические функции</strong></p>

<p style="margin-left:36.0pt"><em>Арифметическая функция называется <strong>вычислимой</strong>, если существует алгоритм для&nbsp; ее вычисления в каждой точке. </em></p>

<p><span style="line-height:1.6em">В силу тезиса Тьюринга это означает, что функция вычислима, если существует машина Тьюринга, ее вычисляющая.</span></p>

<p><strong style="line-height:1.6em"><u>Т. 10.2.(1) Теорема</u></strong></p>

<p><strong>Множество вычислимых арифметических функций счетно.</strong></p>

<p style="margin-left:63.0pt"><strong style="line-height:1.6em"><u>Доказательство</u></strong></p>

<p>Так как каждой вычислимой арифметической функции&nbsp; соответствует хотя бы одна машина Тьюринга, а машин Тьюринга &alefsym;<sub>0</sub>, то значит вычислимых арифметических функций никак не больше&nbsp; чем &alefsym;<sub>0</sub>. Получим: |ВАФ| &le;&alefsym;<sub>0</sub>.</p>

<p>С другой стороны, подмножеством множества вычислимых арифметических функций являются, например, функции вида <em>f</em><em>(</em><em>x</em><em>)=</em><em>n</em>, где <em>n</em> &ndash; натуральное число. Поскольку натуральных&nbsp; чисел &alefsym;<sub>0</sub>, то вычислимых арифметических функций никак не меньше чем &alefsym;<sub>0</sub>. Получим: |ВАФ|&ge;&alefsym;<sub>0</sub>. Значит, мощность множества вычислимых арифметических функций равна &alefsym;<sub>0</sub>, &nbsp;а значит оно <strong><em>счетно</em></strong>, <strong>Q.E.D.</strong></p>

<p><strong style="line-height:1.6em"><u>Т. 10.2.(2) Теорема Тьюринга</u></strong></p>

<p><strong>Множество вычислимых арифметических функций </strong><strong><em>n</em></strong> <strong>переменных не поддается эффективному перечислению.</strong></p>

<p style="margin-left:45.0pt"><strong><u>Доказательство</u></strong></p>

<p>Предположим противное. Пусть множество вычислимых арифметических функций <em>n</em> переменных эффективно перечислимо. Тогда существует алгоритм, по которому его можно перечислить. Применим этот алгоритм. Получим последовательность:</p>

<p><em>f</em><em><sub>0</sub></em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>), </em><em>f</em><em><sub>1</sub></em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>),&hellip;, </em><em>f<sub>n</sub></em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>),&hellip;</em></p>

<p>Построим диагональную функцию:</p>

{!! HTML::image('img/library/Pic/10.1.JPG') !!}

<p><em>Пример</em> (пусть n=3)</p>

<p>&nbsp;<em>g</em><em> (0,0,0)=</em><em>f</em><em><sub>0</sub></em><em>(0,0,0)+1</em></p>

<p>&nbsp;<em>g</em><em> (0,0,1)=0</em></p>

<p>&nbsp;<em>g</em><em> (0,1,0)=0</em></p>

<p>&nbsp;<em>g</em><em> (1,1,1)=</em><em>f</em><em><sub>1</sub></em><em>(1,1,1)+1</em></p>

<p>&nbsp;<em>g</em><em> (1,1,2)=0</em></p>

<p>По построению видно, что функция <em>g</em><em>(x<sub>1</sub>,&hellip;,x<sub>n</sub>)</em> &ndash; арифметическая. Докажем, что, кроме этого, она является вычислимой. Для этого должен существовать алгоритм её вычисления. Укажем алгоритм вычисления <em>g</em><em>(x<sub>1</sub>,&hellip;,x<sub>n</sub>).</em> Для любых значений <em>x<sub>1</sub>,&hellip;,x<sub>n</sub></em> мы можем сначала провести операцию сравнения.</p>

<p>1) Если <em>x<sub>1</sub>=&hellip;=x<sub>n</sub></em>, запускаем алгоритм перечисления вычислимых арифметических функций <em>f<sub>i</sub></em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>).</em> Этот алгоритм существует в силу нашего предположения. Находим функцию с номером <em>x</em><em><sub>1</sub></em>, т.е. <em>f<sub>x</sub></em><em><sub>1</sub></em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>)</em>. Далее применим к ней алгоритм вычисления в точке <em>(x<sub>1</sub>,&hellip;,x<sub>1</sub>)</em>, т.е. вычислим <em>f<sub>x</sub></em><em><sub>1</sub></em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x</em><em><sub>1</sub></em><em>)</em>. Такой алгоритм существует в силу вычислимости функций вида <em>f<sub>i</sub></em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>).</em> Прибавление к результату вычисления единички есть тривиальная арифметическая операция, т.о. при одинаковых значениях аргументов <em>g</em><em>(x<sub>1</sub>,&hellip;,x<sub>n</sub>)<strong> = </strong></em><em>f<sub>x</sub></em><em><sub>1</sub></em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x</em><em><sub>1</sub></em><em>) +1</em> вычислима.</p>

<p>2) Если условие <em>x<sub>1</sub>=&hellip;=x<sub>n</sub></em> не выполняется, т.е. не все значения аргументов равны, то значение <em>g</em><em>(x<sub>1</sub>,&hellip;,x<sub>n</sub>)</em> приравнивается нулю, т.о. при различных значениях аргументов <em>g</em><em>(x<sub>1</sub>,&hellip;,x<sub>n</sub>)=0</em> тоже &nbsp;вычислима.</p>

<p>Т.о. видно, что диагональная функция <em>g</em><em>(x<sub>1</sub>,&hellip;,x<sub>n</sub>)</em> принадлежит множеству вычислимых арифметических функций <em>n</em> переменных.</p>

<p>Раз построенная функция принадлежит к множеству вычислимых арифметических функций, то она должна быть среди ранее эффективно перечисленных функций, но по построению она не может быть среди них, так как от каждой функции она отличается хотя бы в одной точке. Получили противоречие, следовательно, исходное предположение неверно и вычислимые арифметические функции <em>n</em> переменных нельзя эффективно перечислить, <strong>Q.E.D.</strong></p>

<p><strong style="line-height:1.6em"><u>Т. 10.2.(3) Теорема</u></strong></p>

<p><strong>Множество невычислимых арифметических функций несчетно.</strong></p>

<p style="margin-left:63.0pt"><strong style="line-height:1.6em"><u>Доказательство</u></strong></p>

<p>Ранее доказаны два утверждения:</p>

<ul>
	<li>АФ (арифметических функций) несчетное множество.</li>
	<li>ВАФ (вычислимых арифметических функций) счетное множество.</li>
</ul>

<p>Но при этом ВАФ есть подмножество АФ, а значит дополнение ВАФ до АФ (т.е. множество невычислимых функций) является несчетным. Значит, множество невычислимых арифметических функций несчетно, <strong>Q.E.D.</strong></p>

<p><span style="line-height:1.6em">Т.о. доказано, что невычислимые арифметические функции существуют. Более того, их очень много &ndash; несчетное множество. Приведем пример</span><em style="line-height:1.6em"> невычислимой функции</em><span style="line-height:1.6em"> одной переменной.&nbsp;</span></p>

<p><span style="line-height:1.6em">Пусть T</span><sub style="line-height:1.6em">1</sub><span style="line-height:1.6em"> ,T</span><sub style="line-height:1.6em">2 </sub><span style="line-height:1.6em">&hellip; ,T</span><sub style="line-height:1.6em">x</sub><span style="line-height:1.6em">&nbsp; - машины Тьюринга. Определим функцию&nbsp; </span><em style="line-height:1.6em">f</em><sub style="line-height:1.6em">1</sub><span style="line-height:1.6em">(x) следующим образом:</span></p>


{!! HTML::image('img/library/Pic/10.2.JPG') !!}

<p>Эта функция везде определена, но алгоритма для решения проблемы остановки произвольной машины Тьюринга на чистой ленте не существует, значит, не существует алгоритма вычисления <em>f</em><sub>1</sub>(x).</p>

<p>По большому счету, при построении такого рода функций&nbsp; (невычислимых) необходимо соблюдать два основных правила:</p>

<ul>
	<li>Следить за тем, чтобы значение функции в каждой точке было определено и являлось числом натуральным (значит, функция принадлежит множеству арифметических функций);</li>
	<li>В описание функции добавить условие выбора одного из нескольких значений при заданном аргументе, причем само условие выбора должно гарантированно являться алгоритмически неразрешимой проблемой (как минимум для одной точки области определенности, а в общем случае для всех).</li>
</ul>

<p>Тогда полученная функция будет являться невычислимой арифметической функцией.</p>

<p><span style="line-height:1.6em">Важно понимать, что могут существовать различные функции, которые не являются вычислимыми ни в одной точке. Например, приведенная ниже функция также </span><em style="line-height:1.6em">не вычислима</em><span style="line-height:1.6em"> ни в одной точке:</span></p>

<p>{!! HTML::image('img/library/Pic/10.3.JPG') !!}&nbsp; &nbsp; &nbsp;</span></p>

<p><span style="line-height:1.6em">С фактической точки зрения ничего не изменится: по-прежнему ни в одной точке функция </span><em style="line-height:1.6em">f</em><sub style="line-height:1.6em">2</sub><span style="line-height:1.6em">(x) не может быть вычислена, точно также, как ни в одной точке не может быть вычислена функция </span><em style="line-height:1.6em">f</em><sub style="line-height:1.6em">1</sub><span style="line-height:1.6em">(x). Но, тем не менее, </span><em style="line-height:1.6em">f</em><sub style="line-height:1.6em">1</sub><span style="line-height:1.6em">(x) и </span><em style="line-height:1.6em">f</em><sub style="line-height:1.6em">2</sub><span style="line-height:1.6em">(x) - это совсем разные функции, так как они имеют различные&nbsp; </span><em style="line-height:1.6em">описания</em><span style="line-height:1.6em">.</span></p>

<p>Т.о. с точки зрения формально-описательной, даже если рассматривать нигде не вычислимые функции,&nbsp; все приведенные в соответствии с изложенными выше рекомендациями&nbsp; примеры будут определять (задавать) разные функции. Этих функций бесконечно много, однако вопрос о том, счетно ли множество функций, описываемых таким образом, не вполне очевиден.</p>

<p><strong style="line-height:1.6em"><u>Т. 10.2.(4) Теорема (без док-ва)</u></strong></p>

<p><strong>Множество арифметических функций, описываемых конечным числом слов, счетно и эффективно перечислимо.</strong></p>

<p style="margin-left:45.0pt"><strong style="line-height:1.6em"><u>Схема доказательства&nbsp; (доп. материал)</u></strong></p>

<p>Среди функций, описываемых конечным числом слов, содержатся ВСЕ вычислимые функции &nbsp;(алгоритм их вычисления и есть описание) и еще какие то иные, типа приведенных выше примеров <em>f</em><em><sub>1</sub></em><em>(</em><em>x</em><em>)</em> и <em>f</em><em><sub>2</sub></em><em>(</em><em>x</em><em>).</em> Однако на примере нумерации Гёделя, рассмотренной в ходе доказательства &nbsp;теоремы об эффективной перечислимости алгоритмов Маркова, видим, что множество функций, описываемых конечным числом слов&nbsp; (понятий / терминов / идей и т.д.), тоже может быть сопоставлено с рядом натуральных чисел, т.е. является счетным и даже эффективно перечислимым множеством<strong>.</strong></p>

<p><span style="line-height:1.6em">Исходя из вышесказанного, получим, что существует несчетное множество арифметических функций, которые не могут быть даже описаны конечным числом слов (разумеется, об их вычислимости не может идти и речи). Примеры таких функций нельзя привести по определению, в силу того что любой завершенный по своему описанию пример является уже законченным описанием функции, а значит сама функция попадает в множество функций, описываемых конечным числом слов.</span></p>

<p><strong style="line-height:1.6em"><em>Глоссарий учебного элемента</em></strong></p>

<ul style="list-style-type:circle">
	<li>Арифметическая функция &ndash; функция, определенная на расширенном множестве натуральных чисел и принимающая значения из расширенного множества натуральных чисел.</li>
	<li><u>Теорема. </u>Множество арифметических функций n-переменных несчетно.</li>
	<li>Арифметическая функция называется вычислимой, если существует алгоритм для&nbsp; ее вычисления в каждой точке.</li>
	<li><u>Теорема. </u>Множество вычислимых арифметических функций счетно.</li>
	<li><u>Теорема Тьюринга. </u>Множество вычислимых арифметических функций n переменных не поддается эффективному перечислению.</li>
	<li><u>Теорема. </u>Множество невычислимых арифметических функций несчетно.</li>
	<li><u>Теорема. </u>Множество арифметических функций, описываемых конечным числом слов, счетно и эффективно перечислимо.</li>
</ul>

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
