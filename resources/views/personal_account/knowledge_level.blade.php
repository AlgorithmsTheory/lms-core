@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Уровень подготовки студентов</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/dropzone-theme.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('content')
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        @if(isset($error))
            <div class="col-md-12 col-sm-6 card style-danger">
                <h1 class="text-default-bright">При обработке файлов возникли ошибки!</h1>
                <h2 class="text-lg"> {{ $error }} </h2>
            </div>
        @endif
    </div>
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card">
            <div class="card-head style-primary">
                <header>Задать уровень подготовленности студентов</header>
            </div>
            <div class="card-body no-padding">
                <form action="{{URL::route('set_students_level')}}" method="POST" class="dropzone dz-clickable" id="statements-dropzone">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="dz-message">
                        <h3>Вставьте файлы с оценками за предыдущие семестры</h3>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-offset-10 col-md-10 col-sm-6">
            <button class="btn btn-primary btn-raised" type="submit" id="eval-level">Рассчитать уровни</button>
        </div>
    </div>
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <button class="btn btn-warning btn-raised" type="button" id="eval-level-by-test-results">Рассчитать уровни на основе тестов</button>
    </div>
    <script>
        document.getElementById('eval-level-by-test-results').addEventListener('click', async function(ev) {
            console.log('clicked');
            ev.preventDefault();
            try {
                const response = await post('/students-knowledge-level-by-test-results', {});
                if (response.status === 'success') {
                    $('#successModal').modal('show');
                } else {
                    throw new Error('Ошибка при расчете уровней знаний студентов на основе тестов.');
                }
            } catch (error) {
                console.error('Error:', error);
                $('#errorModal').modal('show');
            }
        });

        
        async function post(url, data) {
            return new Promise((res, rej) => {
            $.ajax({
                cache: false,
                type: 'POST',
                url: url,
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: {
                    token: 'token',
                    data: JSON.stringify(data),
                },
                success: data => {
                res(data);
                },
                error: () => {
                rej(new Error('Ошибка'));
                },
            });
            });
        }
    </script>
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Успех</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Уровни знаний студентов успешно пересчитаны!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Ошибка</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ошибка при пересчете уровней знаний студентов.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/knowledge_level.js') !!}
@stop