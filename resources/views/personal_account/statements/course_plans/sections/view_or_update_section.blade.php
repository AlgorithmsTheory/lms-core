<div class="card card-bordered style-success section" id="section{{$sectionNumForFindJs}}" data-id-DB="{{$sectionPlan->id_section_plan}}">
    <form  method="PATCH" id="form_update_section">
    <div class="card-head">

            <header>{{$sectionPlan->section_num." Раздел"}}</header>

        @if($approved == 0)
        <div class="tools disabled_after_approved">
            <div class="btn-group">
                <a class="btn btn-icon-toggle activateEditSection"><i class="glyphicon glyphicon-edit"></i></a>
            </div>
            <div class="btn-group ">
                <a class="btn btn-icon-toggle deleteSection"><i class="md md-close"></i></a>
            </div>
        </div>
            @endif
    </div>
    <div class="card-body style-default-bright">

            {{ csrf_field() }}
            <h5 class="card-title">{!! Form::label('section_plan_name' , 'Название раздела:') !!}
                {!! Form::text('section_plan_name',$sectionPlan->section_plan_name,['class' => 'form-control','placeholder' => 'Введите название учебного плана',
                'required' => 'required', $readOnly ? 'readonly' : '' ]) !!}</h5>
            <p class="card-text">{!! Form::label('section_plan_desc' , 'Описание раздела:') !!}
                {!! Form::text('section_plan_desc',$sectionPlan->section_plan_desc,['class' => 'form-control','placeholder' => 'Введите описание учебного плана',
                 $readOnly ? 'readonly' : '' ]) !!}

                {!! Form::select('is_exam',array('' =>'Выберите тип:',
                '0' => 'Раздел курса',
                '1' => 'Экзамен',
                '2' => 'Зачёт'), $sectionPlan->is_exam, ['id' => 'is_exam','class' => 'form-control', 'required' => 'required', $readOnly ? 'disabled' : '']) !!}
            </p>
            <input type="hidden"  name="id_course_plan" value="{{$sectionPlan->id_course_plan}}" />
            <input type="hidden"  name="id_section_plan" value="{{$sectionPlan->id_section_plan}}" />
            <input type="hidden"  name="section_num_for_find_js" value="{{$sectionNumForFindJs}}" />

            {{--Вывод ошибок валидации--}}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

             {{--Появляется при редактировании раздела--}}
            <div class="update_button_section" style="margin-bottom: 10px">

            </div>



        <div class="content_section row" style="margin-top: 2%; margin-bottom: 2%">
            {{-- добавление lectures, seminars, work on semenar для раздела--}}
            <?php $lectureNumForFindJs = 0; $seminarNumForFindJs = 0; $controlWorkNumForFindJs = 0 ?>

            <div class="lectures col-lg-4">
            @foreach($sectionPlan->lecture_plans as $lecturePlan)
                <?php $lectureNumForFindJs++ ?>
                @include('personal_account.statements.course_plans.sections.lectures.view_or_update_lecture',array('itemSectionPlan' => $lecturePlan, 'readOnly' => true,
                'idCardForFindJs' => $lectureNumForFindJs, 'approved' => $approved))
            @endforeach
            </div>

            <div class="seminars col-lg-4">
                @foreach($sectionPlan->seminar_plans as $seminarPlan)
                    <?php $seminarNumForFindJs++ ?>
                    @include('personal_account.statements.course_plans.sections.seminars.view_or_update_seminar',array('itemSectionPlan' => $seminarPlan, 'readOnly' => true,
                    'idCardForFindJs' => $seminarNumForFindJs, 'approved' => $approved))
                @endforeach
            </div>

            <div class="control_works col-lg-4">
                @foreach($sectionPlan->control_work_plans as $controlWorkPlan)
                    <?php $controlWorkNumForFindJs++ ?>
                    @include('personal_account.statements.course_plans.sections.control_works.view_or_update_control_work',array('itemSectionPlan' => $controlWorkPlan,
                     'readOnly' => true, 'idCardForFindJs' => $controlWorkNumForFindJs, 'approved' => $approved))
                @endforeach
            </div>

        </div>

        @if($approved == 0)
            <div class="disabled_after_approved">
        <button type="button" class="ink-reaction btn btn-info add_lecture_or_sem_or_CW" data-type-card="lecture">Добавить лекцию</button>
        <button type="button" class="ink-reaction btn btn-warning add_lecture_or_sem_or_CW" data-type-card="seminar">Добавить семинар</button>
        <button type="button" class="ink-reaction btn btn-danger add_lecture_or_sem_or_CW " data-type-card="control_work">Добавить К.М.</button>
            </div>
            @endif
    </div>
    </form>
</div>
