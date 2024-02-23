<td style="position: sticky; left: 0; z-index: 3; background: #fff;">{{$statement['user']->group_name}}</td>
<td style="position: sticky; left: 0; z-index: 3; background: #fff;">{{$statement['user']->last_name}}</td>
<td>{{$statement['user']->first_name}}</td>
@foreach ($statement['sections'] as $section)
    @foreach ($section['controls'] as $control)
        <td id="{{$control['id']}}"
            data-id-control_work="{{$control['id']}}"
            data-status="section"
            data-section_num="{{$control['section_num']}}">
            <div class='checkbox checkbox-inline checkbox-styled'>
                <label>
                    <input type='checkbox'
                           {{$control['presence'] ? 'checked' : ''}}
                           class='was'>
                    <span></span>
                </label>
                <span class="points-rounded">{{$control['points']}}</span>
            </div>
            <input type="number"
                   value="{{$control['points_raw']}}"
                   class="result_control_work"
                   style="width: 50px;"
                   step="0.1"
                    {{$control['presence'] ? '' : 'disabled'}}/>
        </td>
    @endforeach
    {{-- ПЛ --}}
    <td>{{$section['lecture']}}</td>
    {{-- ПС --}}
    <td>{{$section['seminar']['presence_points']}}</td>
    {{-- РС --}}
    <td>{{$section['seminar']['work_points']}}</td>
    {{--Итог за раздел--}}
    <td data-result-section_num="{{$section['section_num']}}"
        class="{{$section['total_ok'] ? 'success' : 'danger'}}"
        data-section-max_points="{{$section['control_max_points']}}">
        {{$section['total']}}
    </td>
@endforeach
{{-- Итог за все разделы --}}
<td class="sum_result_section {{$statement['sections_total_ok'] ? 'success' : 'danger'}}"
    data-max_controls="{{$course_plan->max_semester}}">
    {{$statement['sections_total']}}
</td>
{{-- Экзамен (авт + уст части) --}}
@foreach ($statement['exams'] as $exam)
    <td id="{{$exam['id']}}"
        data-id-control_work="{{$exam['id']}}"
        data-status="exam">
        <div class='checkbox checkbox-inline checkbox-styled'>
            <label>
                <input type='checkbox'
                       {{$exam['presence'] ? 'checked' : ''}}
                       class='was'
                        {{$statement['sections_total_ok'] ? '' : 'disabled'}}>
                <span></span>
            </label>
            <span class="points-rounded">{{$exam['points']}}</span>
        </div>
        <input type="number"
               value="{{$exam['points_raw']}}"
               class="result_control_work"
               style="width: 50px;"
               step="1"
                {{$exam['presence'] ? '' : 'disabled'}}
                {{$statement['sections_total_ok'] ? '' : 'disabled'}}>
    </td>
@endforeach
{{-- Итог за экзамены --}}
<td class="sum_result_exam {{$statement['exams_total_ok'] ? 'success' : 'danger'}}"
    data-max_exam="{{$course_plan->max_exam}}">
    {{$statement['exams_total']}}
</td>
{{-- Итог за разделы + за экзамены --}}
<td class="result_all_course {{$statement['summary_total_ok'] ? 'success' : 'danger'}}">
    {{$statement['summary_total']}}
</td>
{{-- Оценка A-F --}}
<td class="mark_bologna {{$statement['summary_total_ok'] ? 'success' : 'danger'}}">
    {{$statement['mark_bologna']}}
</td>
{{-- Оценка 2-5 --}}
<td class="mark_rus {{$statement['summary_total_ok'] ? 'success' : 'danger'}}">
    {{$statement['mark_rus']}}
</td>