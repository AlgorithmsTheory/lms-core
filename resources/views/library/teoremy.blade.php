@extends('templates.base')
@section('head')
    <title>Теоремы к экзамену</title>

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
@stop
@section('content')

<!-- BEGIN BLANK SECTION -->
<section>
    <div class="section-header">
        <ol class="breadcrumb">
            <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
            <li class="active">Теоремы к экзамену</li>
        </ol>
    </div><!--end .section-header -->
</section>
<div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
<article class="style-default-bright">
<div class="card-body">
<article style="margin-left:10%; margin-right:10%">
<table border="1" cellpadding="0" cellspacing="0" ">
	<tbody>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>

			<p style="color: brown"><strong>Название</strong></p>

			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p style="color: brown"><strong>Формулировка </strong><strong>(надо знать обязательно, кроме раздела &laquo;теоремы&raquo; может быть проверена в разделе &laquo;определения&raquo; или &laquo;угадайка&raquo;)</strong></p>
			</td>
			<td style="width:148px">
			<p style="color: brown"><strong>Доказательство </strong><strong>(проверяется в раздеде &laquo;теоремы&raquo;)</strong></p>

			<p>&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Всякая k -ленточная машина Тьюринга М может быть преобразована в эквивалентную машину М* с одной лентой.</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Теорема&nbsp; Шеннона №1</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Всякая машина Тьюринга <em>А</em> может быть преобразована в эквивалентную машину <em>В</em> не более чем с двумя внутренними состояниями.</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз не будет</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Теорема Шеннона №2</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Всякая машина Тьюринга <em>А</em> может быть преобразована в эквивалентную машину <em>С</em> не более чем с двумя знаками внешнего алфавита.</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз не будет</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Задача об остановке произвольной машины Тьюринга на произвольном входном слове алгоритмически неразрешима.</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Задача об остановке произвольной машины Тьюринга на пустой ленте алгоритмически неразрешима</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Задача о печатании данного символа на чистой ленте точно один раз алгоритмически неразрешима</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Задача о печатании данного символа на чистой ленте бесконечно много&nbsp; раз алгоритмически неразрешима</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Задача о печатании данного символа на чистой ленте хотя бы один&nbsp; раз алгоритмически неразрешима</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="height:88px; width:149px">
			<p><strong><u>Теорема Райса</u></strong></p>
			</td>
			<td style="height:88px; width:341px">
			<p>Ни для ка&shy;ко&shy;го не&shy;три&shy;ви&shy;аль&shy;но&shy;го ин&shy;ва&shy;ри&shy;ант&shy;но&shy;го свой&shy;ст&shy;ва ма&shy;шин Тью&shy;рин&shy;га не су&shy;ще&shy;ст&shy;ву&shy;ет алгоритма, по&shy;зво&shy;ля&shy;юще&shy;го для лю&shy;бой ма&shy;ши&shy;ны Тьюрин&shy;га уз&shy;нать, об&shy;ла&shy;да&shy;ет ли она этим свой&shy;ст&shy;вом</p>
			</td>
			<td style="height:88px; width:148px">
			<p>Без доказательства</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество машин Тьюринга эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество алгоритмов Маркова эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Теорема Поста</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Если множество А эффективно перечислимо, то подмножество В эффективно распознается в А тогда и только тогда, когда В и А\В оба эффективно перечислимы</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество останавливающихся машин Тьюринга эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество не останавливающихся машин Тьюринга невозможно эффективно перечислить</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Парадокс Галилея</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Хотя большинство натуральных чисел не является квадратами, всех натуральных чисел не больше, чем квадратов (если сравнивать эти множества по мощности)</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Парадокс Гильберта</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Если гостиница с бесконечным количеством номеров полностью заполнена, в неё можно поселить ещё посетителей, даже бесконечное число</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество целых чисел счетно и эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество упорядоченных пар натуральных чисел счетно и эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество упорядоченных n-ок натуральных чисел счетно и эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество конечных комплексов натуральных чисел счетно и эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество рациональных чисел счетно и эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество алгебраических чисел счетно и эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество элементов, которые можно представить с помощью конечного числа счетной системы знаков, счетно</p>
			</td>
			<td style="width:148px">
			<p>Без доказательства</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество действительных чисел несчётно</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество комплексных чисел несчетно</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество иррациональных чисел несчетно</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество трансцендентных чисел несчетно</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Между любыми двумя различными рациональными числами всегда найдется множество иррациональных чисел мощности континуума</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз не будет</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Между любыми двумя различными иррациональными числами всегда найдется счетное множество рациональных чисел</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз не будет</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Теорема Кантора</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Для любого кардинального числа &alpha; справедливо &alpha;&lt;2<sup>&alpha;</sup></p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Для любого множества А найдется множество В, мощность которого больше А</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз не будет</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Парадокс Кантора</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Кардинальное число множества всех подмножеств P(U) множества всех множеств U не больше чем |U|</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз не будет</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Парадокс Рассела</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Пусть В &ndash; множество всех множеств, которые не содержат самих себя в качестве своих собственных элементов. Тогда можно доказать две теоремы: В принадлежит В и В не принадлежит В</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз не будет</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество вычислимых действительных чисел&nbsp; счетно</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Существуют невычислимые действительные числа и их несчетное множество</p>
			</td>
			<td style="width:148px">
			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество арифметических функций n-переменных несчетно</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество вычислимых арифметических функций счетно</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Теорема Тьюринга</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Множество вычислимых арифметических функций <em>n</em> переменных не поддается эффективному перечислению</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество невычислимых арифметических функций несчетно</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество арифметических функций, описываемых конечным числом слов, счетно и эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз не будет</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество частичных арифметических функций несчетно</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество вычислимых частичных арифметических функций счетно и эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Невозможно эффективно распознать функции-константы среди вычислимых арифметических функций</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Вычислимые арифметические функции не поддаются эффективному сравнению</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Невозможно эффективно распознать функции-тождества среди вычислимых арифметических функций</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Невозможно эффективно распознать вычислимые арифметические функции среди вычислимых частичных арифметических функций</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Теорема Черча</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Невозможно эффективно распознать точки неопределенности вычислимой частичной арифметической функции</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p><strong><u>Теорема о мажорируемых неявных функциях</u></strong></p>
			</td>
			<td style="width:341px">
			<p>Пусть <em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>y</em><em>), </em><em>a</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>)</em> &ndash; такие примитивно-рекурсивные функции, что уравнение <em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>y</em><em>)=0</em></p>

			<p>для каждых <em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em> имеет по меньшей мере одно решение и <em>&mu;<sub>y</sub></em><em>(</em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>y</em><em>)=0) &le; </em><em>a</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>)</em> для любых <em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em> . Тогда функция <em>f</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>)= </em><em>&mu;<sub>y</sub></em><em>(</em><em>g</em><em>(</em><em>x</em><em><sub>1</sub></em><em>,&hellip;,</em><em>x<sub>n</sub></em><em>, </em><em>y</em><em>)=0)</em> также примитивно рекурсивна</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Примитивно-рекурсивные функции эффективно перечислимы</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Множество частично-рекурсивных функций эффективно перечислимо</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Общерекурсивные функции не поддаются эффективному перечислению</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Примитивно-рекурсивные функции не поддаются&nbsp; эффективному распознаванию среди общерекурсивных функций</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
		<tr>
			<td style="width:149px">
			<p>&nbsp;</p>
			</td>
			<td style="width:341px">
			<p>Общерекурсивные функции не поддаются&nbsp; эффективному распознаванию среди частично рекурсивных функций</p>
			</td>
			<td style="width:148px">
			<p>В лекциях есть</p>

			<p>На экз надо знать</p>
			</td>
		</tr>
	</tbody>
</table>

<p><u>ВАЖНО</u></p>

<p>Если у теоремы (парадокса) имеется НАЗВАНИЕ, но нет доказательства, или доказательство помечено как необязательное к запоминанию, то формулировка теоремы может быть проверена на экзамене в разделе &laquo;Определения&raquo; или &laquo;Угадайка&raquo;.</p>

<p>Если у теоремы (парадокса) имеется НАЗВАНИЕ и необходимо знать ДОКАЗАТЕЛЬСТВО, то в билете в разделе &laquo;Теоремы&raquo; может быть приведено ТОЛЬКО название &ndash; формулировка и доказательство должен написать студент. Таких теорем в курсе всего СЕМЬ &ndash; сильно рекомендуется обратить на них особое внимание.</p>

<p>Если у теоремы (парадокса) НЕТ названия и необходимо знать ДОКАЗАТЕЛЬСТВО, то в билете в разделе &laquo;Теоремы&raquo; будет приведена формулировка, возможно с отсутствием ключевого слова (перечислимо/не перечислимо, распознается/не распознается). В этом случае студентом производится уточнение формулировки (обводится нужное ключевое слово) и далее необходимо привести текст доказательства.</p>

<p>Если у теоремы (парадокса) НЕТ названия и нет доказательства, или доказательство помечено как необязательное к запоминанию (т.е. по сути надо знать только формулировку), то на экзамене знание этой формулировки может быть проверено в разделе &laquo;Угадайка&raquo;.</p>


			</article></article>	</div></div>
@stop
@section('js-down')
{!! HTML::script('js/core/source/App.js') !!}
{!! HTML::script('js/core/source/AppNavigation.js') !!}
{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
{!! HTML::script('js/core/source/AppCard.js') !!}
{!! HTML::script('js/core/source/AppForm.js') !!}
{!! HTML::script('js/core/source/AppNavSearch.js') !!}
{!! HTML::script('js/core/source/AppVendor.js') !!}
{!! HTML::script('js/core/demo/Demo.js') !!}
@stop
