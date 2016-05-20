<html>
<body>
{!! Form::open(['method' => 'PATCH', 'class' => 'smart-blue']) !!}
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
                <div class="form-group">
                    <textarea readonly style="resize: vertical" class="form-control" rows="5">{{ $row }}</textarea>
                </div>
            </td>
            @for ($i = 1 ; $i <= $num_var; $i++)
                <td>
                    <div class="checkbox checkbox-inline checkbox-styled">
                        <label>
                            <?php
                                if (in_array( (($num-1)*$num_var+$i) ,$choice)) {
                                   echo "<input type='checkbox' checked > ";
                                }
                                else {
                                    echo "<input type='checkbox'> ";
                                }
                            ?>
                            <span></span>
                        </label>
                    </div>
                </td>
            @endfor
            <?php $num++; ?>
        </tr>
    @endforeach
</table>
{!! Form::close() !!}
</body>
</html>