<div class="card card-bordered style-danger control_work" id="{{$idCardForFindJs}}" data-type-card="control_work">
    <form  method="PATCH" >
        <div class="card-head">

            <header>

                К. М.

            </header>


            <div class="tools">
                <div class="btn-group">
                    <a class="btn btn-icon-toggle activate_edit_lec_sem_cw"><i class="glyphicon glyphicon-edit"></i></a>
                </div>
                <div class="btn-group ">
                    <a class="btn btn-icon-toggle delete_lec_sem_cw"><i class="md md-close"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body style-default-bright">

            {{ csrf_field() }}
            <h5 class="card-title">{!! Form::label('control_work_plan_name' , 'Название К.М.:') !!}
                {!! Form::text('control_work_plan_name',$itemSectionPlan->control_work_plan_name,['class' => 'form-control','placeholder' => 'Введите название К.М.',
                'required' => 'required', $readOnly ? 'readonly' : '' ]) !!}</h5>
            <p class="card-text">{!! Form::label('control_work_plan_desc' , 'Описание К.М.:') !!}
                {!! Form::text('control_work_plan_desc',$itemSectionPlan->control_work_plan_desc,['class' => 'form-control','placeholder' => 'Введите описание К.М.',
                 $readOnly ? 'readonly' : '' ]) !!}

                {!! Form::select('control_work_plan_type',array('' =>'Выберите тип:',
                                'ONLINE_TEST' => 'Автоматизируемый тест системы',
                                'OFFLINE_TEST' => 'Печатный тест системы',
                                'WRITING' => 'Письменная контрольная работа',
                                'VERBAL' => 'Устный опрос'), $itemSectionPlan->control_work_plan_type,
                                ['class' => 'form-control', 'required' => 'required', $readOnly ? 'disabled' : '']) !!}

                {{ Form::select('id_test', array_merge(array('' => 'Выберите тест'), $itemSectionPlan->tests) , $itemSectionPlan->id_test
                , ['class' => 'form-control', 'required' => 'required', $readOnly ? 'disabled' : '']) }}

                {!! Form::label('max_points' , 'Макс балл:') !!}
                {!! Form::text('max_points',$itemSectionPlan->max_points,['class' => 'form-control','placeholder' => 'Введите макс балл'
                ,'required' => 'required', $readOnly ? 'readonly' : '' ]) !!}

            </p>
            <input type="hidden"  name="id_control_work_plan" value="{{$itemSectionPlan->id_control_work_plan}}" />

            {{--Вывод ошибок валидации--}}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            {{--Появляется при редактировании лекции--}}
            <div class="update_button_place" style="margin-bottom: 10px">

            </div>

        </div>
    </form>
</div>
