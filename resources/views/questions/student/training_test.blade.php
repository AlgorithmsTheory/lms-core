<html>
<head>
    <title>Результаты</title>
    {!! HTML::style('css/test_style.css') !!}
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
</head>
<body>
<section>
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="text-default-bright">Ваши результаты</h1>
    </div>
    <div class="col-md-12 col-sm-6 card style-primary">
        <h2 class="text-default-bright">Вы набрали {{$score}} баллов из {{$total}}!</h2>
        <h2 class="text-default-bright">Ваша оценка: {{$mark_bologna}}({{$mark_rus}})</h2>
    </div>
    <table id="result-table">
    <?php $i=1;?>
        @foreach($widgets as $widget)
        <tr>
            <td>{!! $widget !!}</td>
            @if ($right_or_wrong[$i] == 'Верно')
            <td><div class="col-md-12 col-sm-6 card style-success">
                    <h2 class="text-default-bright answer">{{$right_or_wrong[$i]}}</h2>
                    <h2 class="text-default-bright answer">({{$right_percent[$i]}}%)</h2>
             </div></td>
            @endif
            @if ($right_or_wrong[$i] == 'Неверно')
            <td><div class="col-md-12 col-sm-6 card style-danger">
                    <h2 class="text-default-bright answer">{{$right_or_wrong[$i]}}</h2>
                    <h2 class="text-default-bright answer">({{$right_percent[$i]}}%)</h2>
                    <h2 class="text-default-bright answer">{!! link_to_route('lecture', 'Посмотреть в лекциях', $link_to_lecture[$i], ['target' => '_blank'])!!}</h2>
                </div></td>
            @endif
        </tr>
        <?php $i++;?>
        @endforeach
    </table>

    <div class="row">
        <a href="{{URL::route('tests')}}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">К списку тестов</a>
    </div>
</section>
</body>
</html>