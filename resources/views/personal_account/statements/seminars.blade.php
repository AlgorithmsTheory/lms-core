<h2>Посещение семинаров</h2>
{{--Вывод ошибок валидации--}}
<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>
<br>
<table class="table table-condensed table-bordered" data-id-course_plan="{{$course_plan->id_course_plan}}">
    <tr>
        <td rowspan="2" class="warning">Группа</td>
        <td rowspan="2" class="warning">Фамилия</td>
        <td rowspan="2" class="warning">Имя</td>
        @foreach($course_plan->section_plans as $section_plan)
            <td colspan="{{$section_plan->lecture_plans->count()}}" class="info">{{$section_plan->section_num}} Раздел</td>
        @endforeach
    </tr>
    <tr class="active">
        @foreach($course_plan->section_plans as $section_plan)
            @foreach($section_plan->seminar_plans as $seminar_plan)
                <td>{{$seminar_plan->seminar_plan_num}}</td>
            @endforeach
        @endforeach
    </tr>
    <tbody id="target">
    @foreach($statement_seminar as $statement)
        <tr id ="{{$statement['user']->id}}">
            <td>{{$statement['user']->group_name}}</td>
            <td>{{$statement['user']->last_name}}</td>
            <td>{{$statement['user']->first_name}}</td>
            @foreach($statement['seminar_passes_sections'] as $seminar_passes_section)
                @foreach($seminar_passes_section as $seminar_passes)

                <td id="{{$seminar_passes->id_seminar_pass}}"
                    data-id-seminar="{{$seminar_passes->id_seminar_plan}}">
                    <div class='checkbox checkbox-inline checkbox-styled'>
                        <label>
                            <input type='checkbox'
                                   {{$seminar_passes->presence == 1 ? 'checked' : ''}}
                                    class='was'>
                            <span></span>
                        </label>
                    </div>
                    <input type="number"
                           value="{{$seminar_passes->work_points}}"
                           class="classwork"
                           style="width: 50px;"
                           step="any"
                            {{$seminar_passes->presence == 0 ? 'disabled' : ''}}>
                </td>

                @endforeach
            @endforeach
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        @foreach($course_plan->section_plans as $section_plan)
            @foreach($section_plan->seminar_plans as $seminar_plan)
                <td>
                    <button class="btn btn-warning btn-raised all"
                            name="{{ $id_group }}"
                            data-id-seminar="{{$seminar_plan->id_seminar_plan}}">
                        Все
                    </button>
                </td>
            @endforeach
        @endforeach
    </tr>
    </tbody>
</table>



{!! HTML::script('js/statements/seminars.js') !!}