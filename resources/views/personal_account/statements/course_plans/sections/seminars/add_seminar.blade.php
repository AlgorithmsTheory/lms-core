<div class="card card-bordered style-warning seminar" id="{{$idNewCardForFindJs}}"  data-type-card="seminar">
    <form  class="form_store_sem_lec_wc">
        <div class="card-head">
            <header>

                {!! Form::label('seminar_plan_num' , 'Номер семинара:') !!}
                {!! Form::text('seminar_plan_num',$numberNewCard,['class' => 'form-control','placeholder' => 'Номер семинара',
            'required' => 'required', 'style' => 'background-color: white']) !!}

            </header>
            <div class="tools">
                <div class="btn-group ">
                    <a class="btn btn-icon-toggle delete_lec_sem_cw"><i class="md md-close"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body style-default-bright">

            {{ csrf_field() }}
            <h5 class="card-title">{!! Form::label('seminar_plan_name' , 'Название семинара:') !!}
                {!! Form::text('seminar_plan_name',null,['class' => 'form-control','placeholder' => 'Введите название семинара',
                'required' => 'required']) !!}</h5>
            <p class="card-text">{!! Form::label('seminar_plan_desc' , 'Описание семинара:') !!}
                {!! Form::text('seminar_plan_desc',null,['class' => 'form-control','placeholder' => 'Введите описание семинара']) !!}
            </p>


            {{--Вывод ошибок валидации--}}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <button type="button" class="ink-reaction btn btn-warning store_lec_sem_cw" data-btn-type-card="seminar">Сохранить</button>

        </div>
    </form>

</div>
