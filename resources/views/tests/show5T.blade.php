<html>
<body>
<div class="col-md-12 col-sm-6">
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<table>
    <tr>
        <td>Утверждение</td>
        <td>Верно</td>
        <td>Неверно</td>
    </tr>
    <?php $i = 0;?>
    @foreach ($text as $row)
        <tr>
            <td> {{ $row }} </td>
            @if ($choice[$i] == 'true')
            <td><input type="radio"  value="true" checked></td>
            <td><input type="radio"  value="false"></td>
            @else
            <td><input type="radio"  value="true"></td>
            <td><input type="radio"  value="false" checked></td>
            @endif
            <td><input style="display: none;" type="radio"  name="{{$i}}" value="2" checked></td>
        </tr>
        <?php $i++;?>
    @endforeach
</table>
{!! Form::close() !!}
</div>
</body>
</html>