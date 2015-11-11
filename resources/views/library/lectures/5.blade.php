<!DOCTYPE html>
<html lang="en">
<head>
    <title>Лекция 5</title>

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
            <li class="active">Лекция 5. Эффективная перечислимость и распознаваемость.</li>
        </ol>
    </div><!--end .section-header -->
    <div class="section-body">
    </div><!--end .section-body -->
</section>
<div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
<article class="style-default-bright">
<div class="card-body">
<article style="margin-left:10%; margin-right:10%; text-align: justify">
		

<p><span style="line-height:1.2em">Эффективные перечислимость и распознаваемость</span></p>

<p style="margin-left:36.0pt"><strong><em><a name="EPM">Эффективно перечислимым множеством </a></em></strong><em>называется множество, элементы которого можно перечислить по алгоритму (пронумеровать натуральным рядом без пропусков и повторений).</em></p>

<p style="margin-left:36.0pt"><em><a name="5">Подмножество <strong>В</strong> множества <strong>А</strong> <strong>эффективно распознается</strong> в <strong>А</strong>, если существует алгоритм, позволяющий однозначно для каждого элемента множества <strong>А</strong> определить, принадлежит ли данный элемент множеству<strong> В</strong> или дополнению <strong>В</strong> до <strong>А</strong>.</a></em></p>

<p><strong style="line-height:1.6em">Теорема Поста</strong></p>

<p><strong style="line-height:1.6em"><u>Теорема Поста. </u></strong><strong style="line-height:1.6em">Если множество А эффективно перечислимо, то подмножество В эффективно распознается в А тогда и только тогда, когда В и А\В оба эффективно перечислимы.</strong></p>

<p style="margin-left:45.0pt"><strong style="line-height:1.6em"><u>Доказательство</u></strong></p>

<p><em>необходимость</em></p>

<p>Пусть В распознается в А. Множество А представляет собой набор элементов А={a<sub>1</sub>,a<sub>2</sub>,&hellip;}. Вытаскиваем &quot; элемент a<sub>i</sub>&nbsp; из множества A.</p>

<ul>
	<li>Если a<sub>i</sub>&Icirc;B, то нумеруем его в B,</li>
	<li>Если a<sub>i</sub>&Iuml;B, то нумеруем его в А\B.</li>
</ul>

<p>Т.к. A эффективно перечислимо, то таким образом будут вытащены все его элементы. Таким образом эффективно перечислены множества B и А\B.</p>

<p><em>достаточность</em></p>

<p>Пусть B и А\B эффективно перечислимы. Множества В и А\B представляет собой набор элементов B={x<sub>1,</sub>x<sub>2,</sub>&hellip;} и A\B={y<sub>1,</sub>y<sub>2,</sub>&hellip;}. В силу того, что множества В и А\В эффективно перечислимы, существуют алгоритмы их перечисления. Т.к. A эффективно перечислимо, то начнем перечислять его элементы a<sub>i</sub>. Для каждого элемента запустим параллельно алгоритмы перечисления B и A\B (поочерёдно по одному элементу из каждого множества)&nbsp; и будем сравнивать элементы множеств с a<sub>i</sub>. Так как a<sub>i </sub>принадлежит либо В, либо А\В, то он встретится на каком-то конечном шаге перечисления. Таким образом, можно определить, к какому множеству он относится, а значит, B эффективно распознается в А, <strong>Q.E.D.</strong></p>

<p><span style="line-height:1.2em">Эффективное перечисление машин Тьюринга</span></p>

<p><strong style="line-height:1.6em"><u>Теорема. </u></strong><strong style="line-height:1.6em">Множество машин Тьюринга эффективно перечислимо.</strong></p>

<p style="margin-left:45.0pt"><strong><u>&nbsp;Доказательство</u></strong></p>

<p><em>Идея</em>: описать произвольную машину Тьюринга некоторым числом, которое эффективно распознаётся среди натуральных чисел. Тогда, применив алгоритм распознавания к натуральному ряду, удастся перенумеровать все машины Тьюринга. А это будет означать, что они эффективно перечислимы.</p>

<p>Произведём кодировку. Для этого перечислим и пронумеруем состояния (символы внутреннего алфавита) и закодируем их единичками:</p>

<table align="left" border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td style="width:55px">
			<p>S<sub>0</sub></p>
			</td>
			<td style="width:48px">
			<p>&Omega;</p>
			</td>
			<td style="width:44px">
			<p>A</p>
			</td>
			<td style="width:52px">
			<p>B</p>
			</td>
			<td style="width:72px">
			<p>C</p>
			</td>
		</tr>
		<tr>
			<td style="width:55px">
			<p>1-ый&nbsp;&nbsp;</p>
			</td>
			<td style="width:48px">
			<p>2-ой&nbsp;&nbsp;</p>
			</td>
			<td style="width:44px">
			<p>3-ий</p>
			</td>
			<td style="width:52px">
			<p>4-ый</p>
			</td>
			<td style="width:72px">
			<p>5-ый</p>
			</td>
		</tr>
		<tr>
			<td style="width:55px">
			<p>1</p>
			</td>
			<td style="width:48px">
			<p>11</p>
			</td>
			<td style="width:44px">
			<p>111</p>
			</td>
			<td style="width:52px">
			<p>1111</p>
			</td>
			<td style="width:72px">
			<p>11111</p>
			</td>
		</tr>
	</tbody>
</table>

<p>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</p>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</p>
<p>&nbsp;</p>
<p>Пронумеруем ленточные знаки (символы внешнего алфавита) и закодируем их двойками:</p>

<table align="left" border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td style="width:55px">
			<p><em>&part;</em></p>
			</td>
			<td style="width:48px">
			<p>&Lambda;</p>
			</td>
			<td style="width:44px">
			<p>a</p>
			</td>
			<td style="width:52px">
			<p>b</p>
			</td>
			<td style="width:72px">
			<p>c</p>
			</td>
		</tr>
		<tr>
			<td style="width:55px">
			<p>1-ый&nbsp;&nbsp;</p>
			</td>
			<td style="width:48px">
			<p>2-ой&nbsp;&nbsp;</p>
			</td>
			<td style="width:44px">
			<p>3-ий</p>
			</td>
			<td style="width:52px">
			<p>4-ый</p>
			</td>
			<td style="width:72px">
			<p>5-ый</p>
			</td>
		</tr>
		<tr>
			<td style="width:55px">
			<p>2</p>
			</td>
			<td style="width:48px">
			<p>22</p>
			</td>
			<td style="width:44px">
			<p>222</p>
			</td>
			<td style="width:52px">
			<p>2222</p>
			</td>
			<td style="width:72px">
			<p>22222</p>
			</td>
		</tr>
	</tbody>
</table>



<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>Символы, определяющие движение управляющей головки получат коды, состоящие из троек. Стрелку в строке таблицы обозначим четверкой, а разделитель между строк (переход на новую строку), обозначим пятеркой.</p>



<table align="left" border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td style="height:18px; width:56px">
			<p>R</p>
			</td>
			<td style="height:18px; width:49px">
			<p>L</p>
			</td>
			<td style="height:18px; width:45px">
			<p>H</p>
			</td>
			<td style="height:18px; width:45px">
			<p>&rarr;</p>
			</td>
			<td style="height:18px; width:117px">
			<p>новая строка</p>
			</td>
		</tr>
		<tr>
			<td style="height:17px; width:56px">
			<p>3</p>
			</td>
			<td style="height:17px; width:49px">
			<p>33</p>
			</td>
			<td style="height:17px; width:45px">
			<p>333</p>
			</td>
			<td style="height:17px; width:45px">
			<p>4</p>
			</td>
			<td style="height:17px; width:117px">
			<p>5</p>
			</td>
		</tr>
	</tbody>
</table>

<p style="margin-left:27.0pt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Например:&nbsp; А а &rarr; b L B&nbsp;&nbsp; &hArr;&nbsp;&nbsp;&nbsp; 111222422223311115.</p>

<p>&nbsp; &nbsp; &nbsp; &nbsp;Поменяем местами символы элемента алфавита и состояния (в левой части), получим: a A &rarr; b L B&nbsp;&nbsp; &hArr;&nbsp;&nbsp;&nbsp; 22211142222331115.</p>

<p>&nbsp;</p>

<p>Теперь можно убрать &ldquo;4&rdquo; и &ldquo;5&rdquo;, тогда получим&nbsp; 222111222233111, тем самым уменьшив длину кода (данный шаг не является обязательным). Таким образом, каждой машине Тьюринга сопоставлено натуральное число.</p>

<p>Теперь возьмем ряд натуральных чисел и применим к нему алгоритм распознавания, определяющий, является ли данное число кодом какой-либо машины Тьюринга. Если в результате проверки выясняется, что данный формат допустим, то соответствующему числу присваивается очередной свободный номер. Т.о. каждая машина Тьюринга получит свой собственный номер, следовательно, такие машины эффективно перечислимы, <strong>Q.E.D.</strong></p>

<p><strong style="line-height:1.6em">Геделева нумерация и кодовые числа алгоритмов Маркова</strong></p>

<p><strong style="line-height:1.6em"><u>Теорема. </u></strong><strong style="line-height:1.6em">Множество алгоритмов Маркова эффективно перечислимо.</strong></p>

<p style="margin-left:45.0pt"><strong><u>Доказательство</u></strong></p>

<p><em>Идея</em>: описать произвольный алгоритм некоторым числом, которое эффективно распознаётся среди натуральных чисел. Тогда применив алгоритм распознавания к натуральному ряду, удастся перенумеровать все нормальные алгоритмы. А это означает, что они эффективно перечислимы.</p>

<p>Произведём кодировку:</p>

<p>Нормальный&nbsp; алгоритм представляет собой набор строк, например:</p>

<p><strong>ab</strong><strong> &rarr; </strong><strong>c</strong></p>

<p>&Lambda; &rarr; <strong>d</strong><strong>&nbsp; &bull;</strong></p>

<p>Пронумеруем символы алфавита. Первые три символа служебные, для них зарезервируем числа 1,2,3.</p>

<p><strong style="line-height:1.6em">&rarr;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &rdquo;1&rdquo;</strong></p>

<p>&Lambda;<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &rdquo;2&rdquo;</strong></p>

<p><strong>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&rdquo;3&rdquo;</strong></p>

<p>Остальные символы получают следующие вакантные номера:</p>

<p><strong>a</strong><strong> (</strong><strong>x</strong><strong><sub>1</sub></strong><strong>)&nbsp;&nbsp; &rdquo;4&rdquo;</strong></p>

<p><strong>b</strong><strong> (</strong><strong>x</strong><strong><sub>2</sub></strong><strong>)&nbsp;&nbsp; &rdquo;5&rdquo;</strong></p>

<p><strong>c</strong><strong> (</strong><strong>x</strong><strong><sub>3</sub></strong><strong>)&nbsp;&nbsp; &rdquo;6&rdquo;</strong></p>

<p><strong>.&nbsp;&nbsp;&nbsp; .&nbsp;&nbsp;&nbsp; .&nbsp;&nbsp;&nbsp; .</strong></p>

<p><strong>.&nbsp;&nbsp;&nbsp; .&nbsp;&nbsp;&nbsp; .&nbsp;&nbsp;&nbsp; .</strong></p>

<p><strong>&nbsp;(</strong><strong>x<sub>k</sub></strong><strong>)&nbsp;&nbsp; &ldquo;</strong><strong>k</strong><strong>+3&rdquo;</strong></p>

<p><strong style="line-height:1.6em"><em>Отступление</em></strong><em style="line-height:1.6em"> (из области свойств простых чисел). Если мы возьмем ряд простых чисел и каждое из них возведём в какую-нибудь степень, а затем их перемножим, то по полученному числу мы сможем сказать, в какой именно степени были соответствующие простые числа. Это делается путем деления получившегося числа поочередно на простые числа, начиная с двойки, до тех пор, пока возможно деление без остатка. Потом производится деление на 3, потом на 5 и т.д. до тех пор, пока не получится единица.</em></p>

<p><strong><em>2</em></strong><strong><em><sup>x</sup></em></strong><strong><em> &bull; 3</em></strong><strong><em><sup>y</sup></em></strong><strong><em> &bull; 5</em></strong><strong><em><sup>z</sup></em></strong><strong><em> &bull;&hellip;=</em></strong><strong><em>N</em></strong></p>

<p><em>Например, мы можем рассчитать степени, в которые были возведены простые числа, произведение которых образует 540:</em></p>

<p><strong><em>540=2</em></strong><strong><em><sup>x</sup></em></strong><strong><em> &bull; 3</em></strong><strong><em><sup>y</sup></em></strong><strong><em> &bull; 5</em></strong><strong><em><sup>z</sup></em></strong></p>

<p><strong><em>540/2=270; 270/2=135; 135/3=45; 45/3=15; 15/3=5; 5/5=1</em></strong></p>

<p><em>Двойка участвовала в делении 2 раза, тройка - 3 раза, пятерка &ndash; 1 раз. Проверим<strong>: 2<sup>2</sup> &bull; 3<sup>3</sup> &bull; 5<sup>1</sup> =4 &bull; 27 &bull; 5=540</strong></em></p>

<p><span style="line-height:1.6em">Возьмём первую строчку алгоритма Маркова и представим её следующим образом:</span></p>

<p><strong>a</strong>&nbsp;&nbsp;&nbsp;&nbsp; <strong>b</strong><strong>&nbsp;&nbsp;&nbsp; &rarr;&nbsp;&nbsp; </strong><strong>c</strong></p>

<p><strong>2<sup>4 </sup>&bull; 3<sup>5 </sup>&bull; 5<sup>1&nbsp; </sup>&bull; 7<sup>6 </sup>=</strong><strong>A</strong></p>

<p>Полученное натуральное число <strong><em>A</em></strong> является кодом данной строчки (такая нумерация называется Гёделевой).</p>

<p>Аналогично поступаем со второй строчкой алгоритма:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<p>&Lambda;<strong>&nbsp;&nbsp; &rarr;&nbsp; </strong><strong>d</strong> <strong>&bull;</strong></p>

<p><strong>2<sup>2 </sup>&bull; 3<sup>1 </sup>&bull; 5<sup>7 </sup>&bull; 7<sup>3&nbsp; </sup>=</strong><strong>B</strong></p>

<p><strong><em>B</em></strong> является кодом второй строчки.</p>

<p>Далее формируем кодовое число всего алгоритма. Для этого выпишем ряд простых чисел и возведем каждое число в соответствующую этой строчке степень.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<p><strong>2</strong><strong><sup>A</sup></strong><strong>, 3</strong><strong><sup>B</sup></strong><strong>,&hellip;</strong></p>

<p>Перемножив эти числа, получим кодовый номер алгоритма.</p>

<p><strong>2</strong><strong><sup>A</sup></strong><strong>&bull;3</strong><strong><sup>B</sup></strong><strong>&hellip;= К</strong></p>

<p>Таким образом, алгоритм представлен в виде произведения простых чисел, взятых в степенях, соответствующих коду каждой строки. Полученное число <strong>К </strong>является кодом данного алгоритма. При этом по данному коду можно восстановить полностью весь алгоритм.</p>

<p>Теперь возьмем ряд натуральных чисел и применим к нему алгоритм распознавания, определяющий является ли данное число кодом какого либо алгоритма Маркова. Такой алгоритм распознавания будет состоять из двух процедур: сначала по данному числу <strong>К</strong> вычисляются числа <strong>А, </strong><strong>B</strong><strong>, </strong><strong>C</strong>&hellip; (коды строк), а затем из этих чисел извлекаются соответствующие x, y, z,&hellip; (коды символов в рамках каждой строки). Полученные значения проверяются на предмет соответствия формату строк алгоритмов Маркова. Если ответ положительный, то соответствующему числу <strong>К </strong>&nbsp;присваивается очередной свободный номер. Т.о. каждый алгоритм Маркова получит свой собственный номер,&nbsp; следовательно, нормальные алгоритмы эффективно перечислимы, <strong>Q.E.D.</strong></p>

<p><strong style="line-height:1.6em">Различные подмножества множества машин Тьюринга</strong></p>

<p><strong style="line-height:1.6em"><u>Теорема. </u></strong><strong style="line-height:1.6em">Множество останавливающихся машин Тьюринга эффективно перечислимо.</strong></p>

<p style="margin-left:45.0pt"><strong><u>Доказательство</u></strong></p>

<p>Возьмем множество машин, останавливающихся на первом такте, и пронумеруем их: T<sub>11</sub>,T<sub>12</sub>,T<sub>13</sub>,T<sub>14</sub>&hellip;</p>

<p>Затем пронумеруем множество машин, останавливающихся на втором такте: T<sub>21</sub>,T<sub>22</sub>,T<sub>23</sub>,T<sub>24</sub>&hellip;</p>

<p>Аналогично, на третьем такте: T<sub>31</sub>,T<sub>32</sub>,T<sub>33</sub>,T<sub>34</sub>&hellip;, и т.д.</p>

<p>Затем расположим их в виде бесконечной матрицы. Используя диагональный метод, перечислим их (пронумеруем натуральными числами):</p>

<center>{!! HTML::image('img/library/Pic/5.1.jpg') !!}</center>

<p><center><span style="line-height:1.6em">Рис. 1.10. Диагональная нумерация</span></center></p>

<p>Таким образом, каждая останавливающаяся машина Тьюринга получит свой собственный номер. Отсюда следует, что останавливающиеся машины можно эффективно перечислить, <strong>Q.E.D.</strong></p>

<p><strong style="line-height:1.6em"><u>Теорема. </u></strong><strong style="line-height:1.6em">Множество не останавливающихся машин Тьюринга невозможно эффективно перечислить.</strong></p>

<p style="margin-left:45.0pt"><strong style="line-height:1.6em"><u>Доказательство</u></strong></p>

<p>Предположим противное, а именно, что множество не останавливающихся машин эффективно перечислимо. Тогда используем Теорему Поста 1.5.(1), которая гласит, что подмножество В эффективно перечислимого множества А эффективно распознается в нем тогда и только тогда, когда это подмножество и его дополнение до всего множества эффективно перечислимы.</p>

<p>Пусть множество А &ndash; это множество всех машин Тьюринга (оно эффективно перечислимо по Теореме 1.5.(2)), а подмножество В - это множество останавливающихся машин Тьюринга (оно эффективно перечислимо по Теореме 1.5.(4)). Тогда, по Теореме 1.5.(1) и из нашего предположения об эффективной перечислимости не останавливающихся машин Тьюринга &nbsp;следует, что множество останавливающихся машин Тьюринга (В) эффективно распознается среди всех машин Тьюринга (А). Однако этого быть не может, так как общая задача об остановке машины Тьюринга на произвольной ленте неразрешима. Получили противоречие. Значит исходное предположение неверно, т.е. множество&nbsp; не останавливающихся машин Тьюринга эффективно не перечислимо, <strong>Q.E.D.</strong></p>

<h3><strong style="font-size:13px; line-height:1.6em"><em>Глоссарий учебного элемента</em></strong></h3>

<ul style="list-style-type:circle">
	<li>Эффективно перечислимым множеством называется множество, элементы которого можно перечислить по алгоритму (пронумеровать натуральным рядом без пропусков и повторений)</li>
	<li>Подмножество В множества А эффективно распознается в А, если существует алгоритм, позволяющий однозначно для каждого элемента множества А определить, принадлежит ли данный элемент множеству В или дополнению В до А.</li>
	<li><u>Теорема Поста </u>Если множество А эффективно перечислимо, то подмножество В эффективно распознается в А тогда и только тогда, когда В и А\В оба эффективно перечислимы.</li>
	<li><u>Теорема </u>Множество машин Тьюринга эффективно перечислимо.</li>
	<li><u>Теорема </u>&nbsp;Множество алгоритмов Маркова эффективно перечислимо.</li>
	<li><u>Теорема</u> Множество останавливающихся машин Тьюринга эффективно перечислимо.</li>
	<li><u>Теорема</u> Множество не останавливающихся машин Тьюринга невозможно эффективно перечислить.</li>
</ul>

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