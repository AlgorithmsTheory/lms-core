<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<table>
    <tr>
        <td></td>
        @foreach ($variants as $var)
        <td> {{ $var }} </td>
        @endforeach
    </tr>
    <?php $num = 1; ?>
    @foreach ($text as $row)
    <tr>
        <td> {{ $row }} </td>

        @for ($i = 1 ; $i <= $num_var; $i++)
        <td> <input type='checkbox' name="{{($num-1)*$num_var+$i}}"> </td>
        @endfor
        <?php $num++; ?>
    </tr>
    @endforeach
</table>
<input type="checkbox" name="seeLater" class="css-checkbox"><span class="css-checkbox">Вернуться позже</span>
{!! Form::close() !!}
</body>
</html>