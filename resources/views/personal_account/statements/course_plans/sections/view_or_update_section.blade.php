<div class="card card-bordered style-success section" id="section{{$sectionNumForFindJs}}">
    <form  method="PATCH" id="form_update_section">
    <div class="card-head">

            <header>{{$sectionPlan->section_num." Раздел"}}</header>


        <div class="tools">
            <div class="btn-group">
                <a class="btn btn-icon-toggle activateEditSection"><i class="glyphicon glyphicon-edit"></i></a>
            </div>
            <div class="btn-group ">
                <a class="btn btn-icon-toggle deleteSection"><i class="md md-close"></i></a>
            </div>
        </div>
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



        <div id="content-section">
            {{-- adding lectures, seminars, work on semenar for section--}}

        </div>
        <button type="button" class="ink-reaction btn btn-info" id="1">Добавить лекцию</button>
        <button type="button" class="ink-reaction btn btn-warning" id="2">Добавить семинар</button>
        <button type="button" class="ink-reaction btn btn-danger" id="3">Добавить К.М.</button>
    </div>
    </form>
</div>
