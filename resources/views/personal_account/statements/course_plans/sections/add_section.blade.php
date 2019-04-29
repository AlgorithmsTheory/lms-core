<div class="card card-bordered style-success section" id="section{{$section_num_for_find_js}}">
    <form  method="POST" id="form_add_section">
    <div class="card-head">
        <header>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    {!! Form::label('section_num' , 'Номер раздела:') !!}
                </div>
                <div class="col-lg-4 col-md-4">
                {!! Form::text('section_num',$section_num_for_find_js,['class' => 'form-control','placeholder' => 'Номер раздела',
            'required' => 'required', 'style' => 'background-color: white']) !!}
                </div>
            </div>
        </header>
        <div class="tools">
            <div class="btn-group ">
                <a class="btn btn-icon-toggle delete_section"><i class="md md-close"></i></a>
            </div>
        </div>
    </div>
    <div class="card-body style-default-bright">

        {{ csrf_field() }}
        <h5 class="card-title">{!! Form::label('section_plan_name' , 'Название раздела:') !!}
            {!! Form::text('section_plan_name',null,['class' => 'form-control','placeholder' => 'Введите название раздела',
            'required' => 'required']) !!}</h5>
        <p class="card-text">{!! Form::label('section_plan_desc' , 'Описание раздела:') !!}
            {!! Form::text('section_plan_desc',null,['class' => 'form-control','placeholder' => 'Введите описание раздела']) !!}

            {!! Form::select('is_exam',array('' =>'Выберите тип:',
            '0' => 'Раздел курса',
            '1' => 'Экзамен(Зачёт)'), null, ['id' => 'is_exam','class' => 'form-control', 'required' => 'required']) !!}
        </p>
            <input type="hidden"  name="id_course_plan" value="{{$id_course_plan}}" />
            <input type="hidden"  name="section_num_for_find_js" value="{{$section_num_for_find_js}}" />

        {{--Вывод ошибок валидации--}}
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>

            <button type="submit" class="ink-reaction btn btn-success" id="storeSection">Сохранить раздел</button>

    </div>
    </form>
</div>
