<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<table class="table table-bordered no-margin">
    <tr class="info">
        <td>#</td>
        @foreach ($variants as $var)
        <td> {{ $var }} </td>
        @endforeach
    </tr>
    <?php $num = 1; ?>
    @foreach ($text as $row)
    <tr>
        <td class="info">
            <!— <textarea readonly style="resize: vertical" rows="5"> {{ $row }} </textarea>-->
            <div class="form-group">
                <textarea readonly style="resize: vertical" class="form-control" rows="5">{{ $row }}</textarea>
            </div>
        </td>
        @for ($i = 1 ; $i <= $num_var; $i++)
        <!— @foreach ($ans as $a)-->
        <!— @endforeach-->
        <td>
            <div class="checkbox checkbox-inline checkbox-styled">
                <label>
                    <input type='checkbox' name="{{($num-1)*$num_var+$i}}">
                    <span></span>
                </label>
            </div>
        </td>
        @endfor
        <?php $num++; ?>
    </tr>
    @endforeach
</table>
<input type="checkbox" name="seeLater" class="css-checkbox"><span class="css-checkbox">Вернуться позже</span>
{!! Form::close() !!}
</body>
</html>