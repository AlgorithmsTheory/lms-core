<div class="card card-bordered style-danger control_work" id="{{$idCardForFindJs}}" data-type-card="control_work">
    <form  method="PATCH" >
        <div class="card-head">

            <header>

                К. М.

            </header>

            @if($approved == 0)
            <div class="tools disabled_after_approved">
                <div class="btn-group">
                    <a class="btn btn-icon-toggle activate_edit_lec_sem_cw"><i class="glyphicon glyphicon-edit"></i></a>
                </div>
                <div class="btn-group ">
                    <a class="btn btn-icon-toggle delete_lec_sem_cw"><i class="md md-close"></i></a>
                </div>
            </div>
                @endif
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
                                ['class' => 'form-control', 'required' => 'required', $readOnly ? 'disabled' : '', 'id' => 'control_work_plan_type']) !!}


                <select name ="id_test"  class="{{$itemSectionPlan->id_test == null ? "test_select_hide" : ''}} form-control" required {{$readOnly ? 'disabled' : ''}}
                id="id_test">
                    <option value="">Выберите тест</option>
                    @foreach($itemSectionPlan->tests as $test)
                        <option value="{{$test->id_test}}" {{($test->id_test == $itemSectionPlan->id_test) ? 'selected' : ''}}>
                            {{$test->test_name}}
                        </option>
                    @endforeach
                </select>


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
