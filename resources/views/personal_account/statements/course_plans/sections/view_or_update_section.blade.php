<div class="card card-bordered style-success section" id="section{{$section_num_for_find_js}}" id_DB="{{$section_plan->id_section_plan}}">
    <form  method="PATCH" id="form_update_section">
    <div class="card-head">

            <header>{{$section_plan->section_num." Раздел"}}</header>


        <div class="tools">
            <div class="btn-group">
                <a class="btn btn-icon-toggle activate_edit_section"><i class="glyphicon glyphicon-edit"></i></a>
            </div>
            <div class="btn-group ">
                <a class="btn btn-icon-toggle delete_section"><i class="md md-close"></i></a>
            </div>
        </div>
    </div>
    <div class="card-body style-default-bright">

            {{ csrf_field() }}
            <h5 class="card-title">{!! Form::label('section_plan_name' , 'Название раздела:') !!}
                {!! Form::text('section_plan_name',$section_plan->section_plan_name,['class' => 'form-control','placeholder' => 'Введите название учебного плана',
                'required' => 'required', $read_only ? 'readonly' : '' ]) !!}</h5>
            <p class="card-text">{!! Form::label('section_plan_desc' , 'Описание раздела:') !!}
                {!! Form::text('section_plan_desc',$section_plan->section_plan_desc,['class' => 'form-control','placeholder' => 'Введите описание учебного плана',
                 $read_only ? 'readonly' : '' ]) !!}

                {!! Form::select('is_exam',array('' =>'Выберите тип:',
                '0' => 'Раздел курса',
                '1' => 'Экзамен',
                '2' => 'Зачёт'), $section_plan->is_exam, ['id' => 'is_exam','class' => 'form-control', 'required' => 'required', $read_only ? 'disabled' : '']) !!}
            </p>
            <input type="hidden"  name="id_course_plan" value="{{$section_plan->id_course_plan}}" />
            <input type="hidden"  name="id_section_plan" value="{{$section_plan->id_section_plan}}" />
            <input type="hidden"  name="section_num_for_find_js" value="{{$section_num_for_find_js}}" />

            {{--Вывод ошибок валидации--}}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

             {{--Появляется при редактировании раздела--}}
            <div class="update_button_section" style="margin-bottom: 10px">

            </div>



        <div class="content_section row" style="margin-top: 2%; margin-bottom: 2%">
            {{-- добавление lectures, seminars, work on semenar для раздела--}}
            <?php $lecture_num_for_find_js = 0; $seminar_num_for_find_js = 0; $control_work_num_for_find_js = 0 ?>

            <div class="lectures col-lg-4">
            @foreach($section_plan->lecture_plans as $lecture_plan)
                <?php $lecture_num_for_find_js++ ?>
                @include('personal_account.statements.course_plans.sections.lectures.view_or_update_lecture',array('lecture_plan' => $lecture_plan, 'read_only' => true,
                'lecture_num_for_find_js' => $lecture_num_for_find_js))
            @endforeach
            </div>

            <div class="seminars col-lg-4">
                @foreach($section_plan->seminar_plans as $seminar_plan)
                    <?php $seminar_num_for_find_js++ ?>
                    @include('personal_account.statements.course_plans.sections.lectures.view_or_update_lecture',array('seminar_plan' => $seminar_plan, 'read_only' => true,
                    'seminar_num_for_find_js' => $seminar_num_for_find_js))
                @endforeach
            </div>

            <div class="control_works col-lg-4">
                @foreach($section_plan->control_work_plans as $control_work_plan)
                    <?php $control_work_num_for_find_js++ ?>
                    @include('personal_account.statements.course_plans.sections.lectures.view_or_update_lecture',array('control_work_plan' => $control_work_plan,
                     'read_only' => true, 'control_work_num_for_find_js' => $control_work_num_for_find_js))
                @endforeach
            </div>

        </div>

        <button type="button" class="ink-reaction btn btn-info add_lecture_or_sem_or_CW" type_card="lecture">Добавить лекцию</button>
        <button type="button" class="ink-reaction btn btn-warning add_lecture_or_sem_or_CW" type_card="seminar">Добавить семинар</button>
        <button type="button" class="ink-reaction btn btn-danger add_lecture_or_sem_or_CW " type_card="control_work">Добавить К.М.</button>
    </div>
    </form>
</div>
