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
            <td colspan="{{$section_plan->seminar_plans->count()+2}}" class="info">{{$section_plan->section_num}} Раздел </td>
        @endforeach
    </tr>
    <tr class="active">
        @foreach($course_plan->section_plans as $section_plan)
			
            @foreach($section_plan->seminar_plans as $seminar_plan)
                <td>{{$seminar_plan->seminar_plan_num}}</td>
            @endforeach
                <td>Балл за посещения</td>
                <td>Балл за активность</td>
        @endforeach
    </tr>
    <tbody id="target">
    @foreach($statement_seminar as $statement)
        <tr id ="{{$statement['user']->id}}">
            <td style="position: sticky; left: 0; z-index: 3; background: #fff;">{{$statement['user']->group_name}}</td>
            <td style="position: sticky; left: 0; z-index: 3; background: #fff;">{{$statement['user']->last_name}}</td>
            <td>{{$statement['user']->first_name}}</td>
            @foreach($statement['seminar_passes_sections'] as $seminar_passes_section)
                @foreach($seminar_passes_section as $seminar_passes)

                <td id="{{$seminar_passes->id_seminar_pass}}"
                    data-id-seminar="{{$seminar_passes->id_seminar_plan}}"
                    section_num = "{{$seminar_passes->section_num}}">
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
                    <td>{{$statement['ballsBySectionsPass'][$loop->index]}}</td>
                    <td>{{$statement['ballsBySectionsWorks'][$loop->index]}}</td>
            @endforeach
        </tr>
    @endforeach
    <tr class="functionalty_tr">
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
            <td></td>
            <td></td>
        @endforeach
    </tr>
    </tbody>
</table>
<button class="print_to_pdf"> Вывести на печать </button>


{!! HTML::script('js/statements/seminars.js') !!}