<div class="card card-bordered style-danger control_work" id="{{$item_section_plan->id_control_work_plan}}" data-type-card="control_work">
    <form  method="PATCH" >
        <div class="card-head">

            <header>

                К. М.

            </header>

            @if($exist_statements == false)
            <div class="tools ">
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
                {!! Form::text('control_work_plan_name',$item_section_plan->control_work_plan_name,['class' => 'form-control','placeholder' => 'Введите название К.М.',
                'required' => 'required', $read_only ? 'readonly' : '' ]) !!}</h5>
            <p class="card-text">{!! Form::label('control_work_plan_desc' , 'Описание К.М.:') !!}
                {!! Form::text('control_work_plan_desc',$item_section_plan->control_work_plan_desc,['class' => 'form-control','placeholder' => 'Введите описание К.М.',
                 $read_only ? 'readonly' : '' ]) !!}

                {!! Form::select('control_work_plan_type',array('' =>'Выберите тип:',
                                'ONLINE_TEST' => 'Автоматизируемый тест системы',
                                'OFFLINE_TEST' => 'Печатный тест системы',
                                'WRITING' => 'Письменная контрольная работа',
                                'VERBAL' => 'Устный опрос'), $item_section_plan->control_work_plan_type,
                                ['class' => 'form-control', 'required' => 'required', $read_only ? 'disabled' : '', 'id' => 'control_work_plan_type']) !!}


                <select name ="id_test"  class="{{$item_section_plan->id_test == null ? "test_select_hide" : ''}} form-control" required {{$read_only ? 'disabled' : ''}}
                id="id_test">
                    <option value="">Выберите тест</option>
                    @foreach($tests_control_work as $test_control_work)
                        <option value="{{$test_control_work->id_test}}"{{$test_control_work->id_test == $item_section_plan->id_test ? 'selected' : ''}}>
                            {{$test_control_work->test_name}}</option>
                    @endforeach
                </select>


                {!! Form::label('max_points' , 'Макс балл:') !!}
                {!! Form::text('max_points',$item_section_plan->max_points,['class' => 'form-control','placeholder' => 'Введите макс балл'
                ,'required' => 'required', $read_only ? 'readonly' : '' ]) !!}

            </p>
            <input type="hidden"  name="id_control_work_plan" value="{{$item_section_plan->id_control_work_plan}}" />

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
