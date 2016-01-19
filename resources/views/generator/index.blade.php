@extends('templates.base')
@section('head')

<title>Генерация вариантов</title>
@stop
@section('content')
    <div class="section-body" id="page">
        <div class="col-md-12 col-sm-6 card style-primary">
            <h1 class="text-default-bright">Генерация вариантов</h1>
        </div>

        <form action="{{URL::route('generator_pdf')}}" method="POST" class="form">

            <div class="col-lg-offset-1 col-md-10 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <select name="test" id="select-test" class="form-control" size="1" required>
                                @foreach ($tests as $test)
                                <option value="{{$test}}">{{$test}}</option>/td>
                                @endforeach
                            </select>
                            <label for="select-section">Выберите тест</label>
                        </div>
                        <div class="form-group">
                            <input type="number" min="1" value="1" name="num-variants" id="num-variants" class="form-control" required>
                            <label for="total">Количество вариантов</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-offset-1 col-md-2 col-sm-6" id="generate">
                <button class="btn btn-primary btn-raised submit-test" type="submit">Сгенерировать</button>
            </div>
        </form>
    </div>
@stop