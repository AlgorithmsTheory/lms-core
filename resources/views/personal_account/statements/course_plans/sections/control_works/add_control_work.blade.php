<div class="card card-bordered style-danger control_work" id="{{$idNewCardForFindJs}}"  data-type-card="control_work">
    <form  class="form_store_sem_lec_wc">
        <div class="card-head">
            <header>
               К. М.
            </header>
            <div class="tools">
                <div class="btn-group ">
                    <a class="btn btn-icon-toggle delete_lec_sem_cw"><i class="md md-close"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body style-default-bright">

            {{ csrf_field() }}
            <h5 class="card-title">{!! Form::label('control_work_plan_name' , 'Название К.М.:') !!}
                {!! Form::text('control_work_plan_name',null,['class' => 'form-control','placeholder' => 'Введите название К.М.',
                'required' => 'required']) !!}</h5>
            <p class="card-text">{!! Form::label('control_work_plan_desc' , 'Описание К.М.:') !!}
                {!! Form::text('control_work_plan_desc',null,['class' => 'form-control','placeholder' => 'Введите описание К.М.']) !!}

                {!! Form::select('control_work_plan_type',array('' =>'Выберите тип:',
                'ONLINE_TEST' => 'Автоматизируемый тест системы',
                'OFFLINE_TEST' => 'Печатный тест системы',
                'WRITING' => 'Письменная контрольная работа',
                'VERBAL' => 'Устный опрос'), null, ['class' => 'form-control', 'required' => 'required', $readOnly ? 'disabled' : '']) !!}

                {{ Form::select('id_test', array_merge(array('' => 'Выберите тест'), $tests_control_work) , null
                , ['class' => 'form-control', 'required' => 'required']) }}

                {!! Form::label('max_points' , 'Макс балл:') !!}
                {!! Form::text('max_points',null,['class' => 'form-control','placeholder' => 'Введите макс балл'
                ,'required' => 'required']) !!}
            </p>


            {{--Вывод ошибок валидации--}}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <button type="button" class="ink-reaction btn btn-danger store_lec_sem_cw" data-btn-type-card="control_work">Сохранить</button>

        </div>
    </form>

</div>
