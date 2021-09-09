<h2>Посещение лекций</h2>
<br>
<table class="table table-condensed table-bordered" data-id-course_plan="{{$course_plan->id_course_plan}}">
    <tr>
        <td rowspan="2" class="warning" style="width: 20px">Группа</td>
        <td rowspan="2" class="warning" style="width: 20px">Фамилия</td>
        <td rowspan="2" class="warning" style="width: 20px">Имя</td>
        @foreach($course_plan->section_plans as $section_plan)
            <td colspan="{{$section_plan->lecture_plans->count() + 1}}" class="info">{{$section_plan->section_num}} Раздел
            </td>
        @endforeach
    </tr>
    <tr class="active">
        @foreach($course_plan->section_plans as $section_plan)
            @foreach($section_plan->lecture_plans as $lecture_plan)

                    <td>{{$lecture_plan->lecture_plan_num}}</td>
            @endforeach
            <td>Итог</td>
        @endforeach

    </tr>
    <tbody id="target">
    @foreach($statement_lecture as $statement)
            <tr id ="{{$statement['user']->id}}">
            <td>{{$statement['user']->group_name}}</td>
            <td>{{$statement['user']->last_name}}</td>
            <td>{{$statement['user']->first_name}}</td>
            @foreach($statement['lecture_passes'] as $lecture_sections)
                @foreach($lecture_sections as $lecture_passes)
                    <td>
                        <div class='checkbox checkbox-inline checkbox-styled'>
                            <label>

                                <input type='checkbox' {{$lecture_passes->presence == 1 ? 'checked' : ''}}
                                       class='was'
                                       data-id-lecture="{{$lecture_passes->id_lecture_plan}}">
                                <span></span>
                            </label>
                        </div>


                    </td>
                @endforeach
                <td>{{round($statement['ballsBySections'][$loop->index], 2)}}</td>
            @endforeach
            </tr>
    @endforeach
    <tr class="functionalty_tr">
        <td></td>
        <td></td>
        <td></td>
        @foreach($course_plan->section_plans as $section_plan)
            @foreach($section_plan->lecture_plans as $lecture_plan)
                <td>
                    <button class="btn btn-warning btn-raised all"
                            name="{{ $id_group }}"
                            data-id-lecture="{{$lecture_plan->id_lecture_plan}}">
                        Все
                    </button>
                </td>
            @endforeach
            <td></td>
        @endforeach
    </tr>

    </tbody>
</table>
<button class="print_to_pdf"> Вывести на печать </button>


{!! HTML::script('js/statements/lectures.js') !!}