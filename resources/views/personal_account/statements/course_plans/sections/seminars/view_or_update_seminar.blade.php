<div class="card card-bordered style-warning seminar" id="{{$item_section_plan->id_seminar_plan}}" data-type-card="seminar">
    <form  method="PATCH" >
        <div class="card-head">

            <header>

                {!! Form::label('seminar_plan_num' , 'Номер семинара:') !!}
                {!! Form::text('seminar_plan_num',$item_section_plan->seminar_plan_num,['class' => 'form-control','placeholder' => 'Номер лекции',
            'required' => 'required', 'style' => 'background-color: white' , $read_only ? 'readonly' : '']) !!}

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
            <h5 class="card-title">{!! Form::label('seminar_plan_name' , 'Название семинара:') !!}
                {!! Form::text('seminar_plan_name',$item_section_plan->seminar_plan_name,['class' => 'form-control','placeholder' => 'Введите название семинара',
                'required' => 'required', $read_only ? 'readonly' : '' ]) !!}</h5>
            <p class="card-text">{!! Form::label('seminar_plan_desc' , 'Описание семинара:') !!}
                {!! Form::text('seminar_plan_desc',$item_section_plan->seminar_plan_desc,['class' => 'form-control','placeholder' => 'Введите описание семинара',
                 $read_only ? 'readonly' : '' ]) !!}
            </p>
            <input type="hidden"  name="id_seminar_plan" value="{{$item_section_plan->id_seminar_plan}}" />

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
