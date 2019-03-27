<div class="card card-bordered style-info lecture" id="{{$idCardForFindJs}}" data-type-card="lecture">
    <form  method="PATCH" >
        <div class="card-head">

            <header>

                {!! Form::label('lecture_plan_num' , 'Номер лекции:') !!}
                {!! Form::text('lecture_plan_num',$itemSectionPlan->lecture_plan_num,['class' => 'form-control','placeholder' => 'Номер лекции',
            'required' => 'required', 'style' => 'background-color: white' , $readOnly ? 'readonly' : '']) !!}

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
            <h5 class="card-title">{!! Form::label('lecture_plan_name' , 'Название лекции:') !!}
                {!! Form::text('lecture_plan_name',$itemSectionPlan->lecture_plan_name,['class' => 'form-control','placeholder' => 'Введите название лекции',
                'required' => 'required', $readOnly ? 'readonly' : '' ]) !!}</h5>
            <p class="card-text">{!! Form::label('lecture_plan_desc' , 'Описание раздела:') !!}
                {!! Form::text('lecture_plan_desc',$itemSectionPlan->lecture_plan_desc,['class' => 'form-control','placeholder' => 'Введите описание лекции',
                 $readOnly ? 'readonly' : '' ]) !!}
            </p>
            <input type="hidden"  name="id_lecture_plan" value="{{$itemSectionPlan->id_lecture_plan}}" />

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
