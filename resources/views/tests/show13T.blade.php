<div class="col-md-12 col-sm-6">
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>
    @for ($i = 0; $i < count($text); $i++)
        @if ($i % 2 == 0) {{ $text[$i] }}
        @else {!! HTML::image($text[$i]) !!}
        @endif
    @endfor
</h2>
<input type="hidden" name="num" value="{{ $id }}" />
<input type="hidden" name="type" value="{{ $type }}" />

<h4><b>Эмулятор Маркова</b></h4>
<h4>Тестов прошло: {{$choice['sequences_true']}} / {{$choice['sequences_all']}}</h4>
<h4>Количество проверок (нажатий "Проверить работу"): {{$choice['debug_counter']}}</h4>
<h4>Количество запусков: {{$choice['run_counter']}}</h4>
<h4>Количество отладок (запусков с шагами): {{$choice['steps_counter']}}</h4>
<h4>Процент верно пройденных тестов: {{$choice['right_percent']}}%</h4>
<h4>Штраф за проверки, запуски и отладки составил: {{$choice['fee_percent']}}%</h4>
<h4>Суммарное количество итераций: {{$choice['total_cycle']}}</h4>
<h4>Количество баллов: {{$choice['score']}}</h4>

{!! Form::close() !!}
<br>
</div>
