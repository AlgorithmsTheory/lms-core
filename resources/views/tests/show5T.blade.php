<html>
<body>
<div class="col-md-12 col-sm-6">
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<table class="table table-bordered no-margin">
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
            @elseif ($choice[$i] == 'false')
            <td><input type="radio"  value="true"></td>
            <td><input type="radio"  value="false" checked></td>
            @else
            <td><input type="radio"  value="true"></td>
            <td><input type="radio"  value="false"></td>
            @endif
        </tr>
        <?php $i++;?>
    @endforeach
</table>
{!! Form::close() !!}
</div>
</body>
</html>