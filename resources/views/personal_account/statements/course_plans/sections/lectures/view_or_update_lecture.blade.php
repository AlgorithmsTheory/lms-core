<div class="card card-bordered style-info lecture" id="{{$lectureNumForFindJs}}" >
    <form  method="PATCH" class="form_update_lecture">
        <div class="card-head">

            <header>

                {!! Form::label('lecture_plan_num' , 'Номер лекции:') !!}
                {!! Form::text('lecture_plan_num',$lecturePlan->lecture_plan_num,['class' => 'form-control','placeholder' => 'Номер лекции',
            'required' => 'required', 'style' => 'background-color: white' , $readOnly ? 'readonly' : '']) !!}

            </header>


            <div class="tools">
                <div class="btn-group">
                    <a class="btn btn-icon-toggle activate_edit_lecture"><i class="glyphicon glyphicon-edit"></i></a>
                </div>
                <div class="btn-group ">
                    <a class="btn btn-icon-toggle delete_lecture"><i class="md md-close"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body style-default-bright">

            {{ csrf_field() }}
            <h5 class="card-title">{!! Form::label('lecture_plan_name' , 'Название лекции:') !!}
                {!! Form::text('lecture_plan_name',$lecturePlan->lecture_plan_name,['class' => 'form-control','placeholder' => 'Введите название лекции',
                'required' => 'required', $readOnly ? 'readonly' : '' ]) !!}</h5>
            <p class="card-text">{!! Form::label('lecture_plan_desc' , 'Описание раздела:') !!}
                {!! Form::text('lecture_plan_desc',$lecturePlan->lecture_plan_desc,['class' => 'form-control','placeholder' => 'Введите описание лекции',
                 $readOnly ? 'readonly' : '' ]) !!}
            </p>

            {{--Вывод ошибок валидации--}}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            {{--Появляется при редактировании лекции--}}
            <div class="update_button_lecture" style="margin-bottom: 10px">

            </div>

        </div>
    </form>
</div>
