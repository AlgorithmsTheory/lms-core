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
            <td colspan="{{$section_plan->control_work_plans->count() + 4}}" class="info">
                {{$section_plan->section_num . ' Раздел'}}
            </td>
        @endforeach

        <td colspan="1" rowspan="2" class="info">Итог за разделы</td>

        @foreach($course_plan->exam_plans as $exam_plan)
            <td colspan="{{$exam_plan->control_work_plans->count()}}" class="info">
                Экзамен (Зачёт)
            </td>
        @endforeach

        <td colspan="1" rowspan="2" class="info">Итог за Экзамен (Зачёт)</td>

       <!--- <td colspan="1" rowspan="2" class="info">Пос. лек.</td>--->
    <!---   <td colspan="1" rowspan="2" class="info">Пос. сем.</td>--->
       <!---  <td colspan="1" rowspan="2" class="info">Раб. сем.</td>--->
        <td colspan="1" rowspan="2" class="info">Суммарный итог</td>
        <td rowspan="3" class="info">Оценка (A-F)</td>
        <td rowspan="3" class="info">Оценка (2-5)</td>
    </tr>
    <tr class="active">
        @foreach($course_plan->section_plans as $section_plan)
            @foreach($section_plan->control_work_plans as $control_work_plan)
                <td>{{$control_work_plan->control_work_plan_name}}</td>
            @endforeach

            <td>ПЛ</td>
            <td>ПС</td>
            <td>РС</td>
            <td class="info" rowspan="2">Итог: {{$section_plan->getOverallMaxPoints()}}</td>
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
                <td>max: {{$control_work_plan->max_points}}</td>
            @endforeach
{{--            <script>console.log('{{json_encode($section_plan)}}')</script>--}}
                <td>max: {{$section_plan->max_lecture_pass_point}}</td>
                <td>max: {{$section_plan->max_seminar_pass_point}}</td>
                <td>max: {{$section_plan->max_seminar_work_point}}</td>
        @endforeach

        <td>max: {{$course_plan->max_semester}}</td>

        {{--Вывод макс баллов К.М в разделе Экзамен(Зачёт)--}}
        @foreach($course_plan->exam_plans as $exam_plan)
            @foreach($exam_plan->control_work_plans as $control_work_plan)
                <td>max: {{$control_work_plan->max_points}}</td>
            @endforeach
        @endforeach

        <td>max: {{$course_plan->max_exam}}</td>
        <td>max: {{$course_plan->max_semester + $course_plan->max_exam}}</td>

    </tr>
    <tbody id="target">
    @foreach($statement_result as $statement)
        @include('personal_account.statements.one_result', array('statement' => $statement, 'course_plan' => $course_plan))
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
            <td></td>
            <td></td>
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

<button class="print_to_pdf"> Вывести на печать </button>

<h2>Генерация ведомостей</h2>
<div>
    <style>
        .generating-statements {
            padding: 15px 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .generating-statements_buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
    </style>
    <form action="" method="" class="form generating-statements" id="forma">
        <input id="image-file" type="file" />
        <div class="generating-statements_buttons">
            <button class="btn-gen-statement" data-type="credit">Зачёт</button>
            <button class="btn-gen-statement" data-type="credit-with-grade">Зачёт с оценкой</button>
            <button class="btn-gen-statement" data-type="exam">Экзамен</button>
            <button class="btn-gen-statement" data-type="section-evaluation">Аттестация разделов</button>
        </div>
    </form>
</div>
{!! HTML::script('js/statements/results.js') !!}