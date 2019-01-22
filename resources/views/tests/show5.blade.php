<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => $route, 'class' => 'smart-blue question-form']) !!}
<h1>Вопрос {{ $count }}</h1>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<table class="table table-bordered no-margin text-lg">
    <tr>
        <td>Утверждение</td>
        <td>Верно</td>
        <td>Неверно</td>
    </tr>
    <?php $i = 1;?>
    @foreach ($text as $row)
    <tr>
        <td> {{ $row }} </td>
        <td>
            <div class="radio radio-styled">
                <label>
                    <input type="radio"  name="{{$i}}" value="true">
                    <span class="text-lg"></span>
                </label>
            </div>
        </td>
        <td>
            <div class="radio radio-styled">
                <label>
                    <input type="radio"  name="{{$i}}" value="false">
                    <span class="text-lg"></span>
                </label>
            </div>
        </td>
        <td>
            <input style="display: none;" type="radio"  name="{{$i}}" value="2" checked>
        </td>
    </tr>
    <?php $i++;?>
    @endforeach
</table>
@if (!$is_adaptive)
    <div class="checkbox checkbox-styled checkbox-warning">
        <label>
            <input type="checkbox" name="seeLater" class="css-checkbox">
            <span class="css-checkbox text-lg">Вернуться позже</span>
        </label>
    </div>
@endif
{!! Form::close() !!}
</body>
</html>