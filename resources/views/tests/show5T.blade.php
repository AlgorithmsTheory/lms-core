<html>
<body>
<div class="col-md-12 col-sm-6">
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<table class="table table-bordered no-margin text-lg">
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
            <td>
                <div class="radio radio-styled">
                    <label>
                        <input type="radio"  value="true" checked>
                        <span class="text-lg"></span>
                    </label>
                </div>
            </td>
            <td>
                <div class="radio radio-styled">
                    <label>
                        <input type="radio"  value="false">
                        <span class="text-lg"></span>
                    </label>
                </div>
            </td>
            @elseif ($choice[$i] == 'false')
            <td>
                <div class="radio radio-styled">
                    <label>
                        <input type="radio"  value="true">
                        <span class="text-lg"></span>
                    </label>
                </div>
            </td>
            <td>
                <div class="radio radio-styled">
                    <label>
                        <input type="radio"  value="false" checked>
                        <span class="text-lg"></span>
                    </label>
                </div>
            </td>
            @else
            <td>
                <div class="radio radio-styled">
                    <label>
                        <input type="radio"  value="true">
                        <span class="text-lg"></span>
                    </label>
                </div>
            </td>
            <td>
                <div class="radio radio-styled">
                    <label>
                        <input type="radio"  value="false">
                        <span class="text-lg"></span>
                    </label>
                </div>
            </td>
            @endif
        </tr>
        <?php $i++;?>
    @endforeach
</table>
{!! Form::close() !!}
</div>
</body>
</html>