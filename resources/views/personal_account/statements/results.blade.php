<h2>Итоговые результаты</h2>
{{--Вывод ошибок валидации--}}
<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>
<br>
{{--{{$statement_result[0]['exam_work_groupBy_sections']}}--}}
<table class="table table-condensed table-bordered"
       data-id-course_plan="{{$course_plan->id_course_plan}}"
        data-id_group="{{$id_group}}">
    <tr class="info">
        <td rowspan="3" class="warning">Группа</td>
        <td rowspan="3" class="warning">Фамилия</td>
        <td rowspan="3" class="warning">Имя</td>
        @foreach($course_plan->section_plans as $section_plan)
            <td colspan="{{$section_plan->control_work_plans->count() + 1}}" class="info">
                    {{$section_plan->section_num . ' Раздел'}}
            </td>
        @endforeach

        <td colspan="1" rowspan="2" class="info">Итог за разделы</td>

        @foreach($course_plan->exam_plans as $exam_plan)
            <td colspan="{{$exam_plan->control_work_plans->count()}}" class="info">
                    Экзамен(Зачёт)
            </td>
        @endforeach

        <td colspan="1" rowspan="2" class="info">Итог за Экзамен(Зачёт)</td>

        <td colspan="1" rowspan="2" class="info">Пос. лек.</td>
        <td colspan="1" rowspan="2" class="info">Пос. сем.</td>
        <td colspan="1" rowspan="2" class="info">Раб. сем.</td>
        <td colspan="1" rowspan="2" class="info">Суммарный итог</td>
        <td rowspan="3" class="info">Оценка(A-F)</td>
        <td rowspan="3" class="info">Оценка(2-5)</td>
    </tr>
    <tr class="active">
        @foreach($course_plan->section_plans as $section_plan)
            @foreach($section_plan->control_work_plans as $control_work_plan)
                    <td>{{$control_work_plan->control_work_plan_name}}</td>
            @endforeach
                <td class="info" rowspan="2">Итог</td>
        @endforeach

            @foreach($course_plan->exam_plans as $exam_plan)
                @foreach($exam_plan->control_work_plans as $control_work_plan)
                    <td>{{$control_work_plan->control_work_plan_name}}</td>
                @endforeach
            @endforeach
    </tr>
    <tr class="active">
            {{--Вывод макс баллов К.М в обычных разделов--}}
        @foreach($course_plan->section_plans as $section_plan)
            @foreach($section_plan->control_work_plans as $control_work_plan)
                <td>max {{":".$control_work_plan->max_points}}</td>
            @endforeach
        @endforeach

        <td>max {{":".$course_plan->max_controls}}</td>

        {{--Вывод макс баллов К.М в разделе Экзамен(Зачёт)--}}
            @foreach($course_plan->exam_plans as $exam_plan)
                @foreach($exam_plan->control_work_plans as $control_work_plan)
                    <td>max {{":".$control_work_plan->max_points}}</td>
                @endforeach
            @endforeach

            <td>max {{":".$course_plan->max_exam}}</td>

            <td>max {{":".$course_plan->max_lecrures}}</td>
            <td>max {{":".$course_plan->max_seminars}}</td>
            <td>max {{":".$course_plan->max_seminars_work}}</td>
            <td>max :100</td>

    </tr>
    <tbody id="target">
    @foreach($statement_result as $statement)
        <tr id ="{{$statement['user']->id}}">
            <td>{{$statement['user']->group_name}}</td>
            <td>{{$statement['user']->last_name}}</td>
            <td>{{$statement['user']->first_name}}</td>
            {{--Вывод контрольных мероприятий по разделам + итоги в каждом разделе--}}
            @if(!$statement['control_work_groupBy_sections']->isEmpty())

                @foreach($course_plan->section_plans as $section_plan)
                    @foreach($statement['control_work_groupBy_sections'][$section_plan->section_num] as $control_work_passes)

                    <td id="{{$control_work_passes->id_control_work_pass}}"
                        data-id-control_work="{{$control_work_passes->id_control_work_plan}}"
                        data-status="section"
                        data-section_num="{{$control_work_passes->section_num}}">
                        <div class='checkbox checkbox-inline checkbox-styled'>
                            <label>
                                <input type='checkbox'
                                       {{$control_work_passes->presence == 1 ? 'checked' : ''}}
                                       class='was'>
                                <span></span>
                            </label>
                        </div>
                        <input type="number"
                               value="{{$control_work_passes->points}}"
                               class="result_control_work"
                               style="width: 50px;"
                               step="any"
                                {{$control_work_passes->presence == 0 ? 'disabled' : ''}}/>
                    </td>
                @endforeach
                    {{--Итог за раздел--}}
                <td data-result-section_num="{{$section_plan->section_num}}"
                    class="{{$statement['result_control_work_sections']->get($section_plan->section_num) < $section_plan->max_points * 0.6
                    ? 'danger' : 'success'}}"
                    data-section-max_points="{{$section_plan->max_points}}">
                    {{round($statement['result_control_work_sections']->get($section_plan->section_num), 1)}}
                </td>
            @endforeach



            {{--Вывод итогов всех К.М. за все разделы--}}
            <td class="sum_result_section {{$statement['sum_result_section_control_work'] < $course_plan->max_controls * 0.6
                ? 'danger' : 'success'}}"
                data-max_controls="{{$course_plan->max_controls}}">
                {{round($statement['sum_result_section_control_work'], 1)}}
            </td>
            @endif

            {{--Вывод экзаменационных мероприятий --}}
            @if(!$statement['exam_work_groupBy_sections']->isEmpty())

            @foreach($course_plan->exam_plans as $exam_plan)
                @foreach($statement['exam_work_groupBy_sections'][$exam_plan->id_section_plan] as $control_work_passes)

                    <td id="{{$control_work_passes->id_control_work_pass}}"
                        data-id-control_work="{{$control_work_passes->id_control_work_plan}}"
                        data-status="exam">
                        <div class='checkbox checkbox-inline checkbox-styled'>
                            <label>
                                <input type='checkbox'
                                       {{$control_work_passes->presence == 1 ? 'checked' : ''}}
                                       class='was'>
                                <span></span>
                            </label>
                        </div>
                        <input type="number"
                               value="{{round($control_work_passes->points, 1)}}"
                               class="result_control_work"
                               style="width: 50px;"
                               step="any"
                                {{$control_work_passes->presence == 0 ? 'disabled' : ''}}>
                    </td>
                @endforeach
            @endforeach

            {{--Итог за Экзамен(Зачёт)--}}
                <td class="sum_result_exam {{$statement['sum_result_section_exam_work'] < $course_plan->max_exam * 0.6
                ? 'danger' : 'success'}}"
                data-max_exam="{{$course_plan->max_exam}}">
                    {{round($statement['sum_result_section_exam_work'], 1)}}
                </td>

            {{--Пос. лек.--}}

                <td>{{round($statement['result_lecture'], 1)}}</td>

            {{--Пос. Семинаров.--}}

                <td>{{round($statement['result_seminar'], 1)}}</td>

            {{--Раб. на сем--}}

                <td>{{round($statement['result_work_seminar'], 1)}}</td>

            {{--Суммарный итог--}}

                <td class="result_all_course {{$statement['sum_result'] < 60 || $statement['sum_result_section_exam_work'] < $course_plan->max_exam * 0.6 ? 'danger' : 'success'}}">
                    {{round($statement['sum_result'], 1)}}
                </td>

                {{--Оценка(A-F)--}}

                <td class="mark_bologna {{$statement['sum_result'] < 60 || $statement['sum_result_section_exam_work'] < $course_plan->max_exam * 0.6 ? 'danger' : 'success'}}">
                    {{$statement['markBologna']}}
                </td>

                {{--Оценка(2-5)--}}

                <td class="mark_rus {{$statement['sum_result'] < 60 || $statement['sum_result_section_exam_work'] < $course_plan->max_exam * 0.6 ? 'danger' : 'success'}}">
                    {{$statement['markRus']}}
                </td>

            @endif
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        @foreach($course_plan->section_plans as $section_plan)
            @foreach($section_plan->control_work_plans as $control_work_plan)
                <td>
                    <button class="btn btn-warning btn-raised all"
                            name="{{ $id_group }}"
                            data-id-control_work="{{$control_work_plan->id_control_work_plan}}">
                        Все
                    </button>
                </td>
            @endforeach
            <td></td>
        @endforeach
        <td></td>
        @foreach($course_plan->exam_plans as $exam_plan)
            @foreach($exam_plan->control_work_plans as $control_work_plan)
                <td>
                    <button class="btn btn-warning btn-raised all"
                            name="{{ $id_group }}"
                            data-id-control_work="{{$control_work_plan->id_control_work_plan}}">
                        Все
                    </button>
                </td>
            @endforeach
        @endforeach
    </tr>
    </tbody>
</table>

{!! HTML::script('js/statements/results.js') !!}