<?php


namespace App\Statements;
use App\Statements\Passes\SeminarPasses;
use App\Testing\Test;
use Illuminate\Http\Request;
use App\User;
use App\Group;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Statements\DAO\SectionPlanDAO;
use App\Statements\DAO\CoursePlanDAO;
use App\Statements\Passes\ControlWorkPasses;
use Illuminate\Support\Collection;
use Response;
use Validator;
use Illuminate\Support\Facades\DB;

class ResultStatement {
    private $course_plan_DAO;
    private $section_plan_DAO;
    public function __construct(CoursePlanDAO $course_plan_DAO,SectionPlanDAO $section_plan_DAO)
    {
        $this->course_plan_DAO = $course_plan_DAO;
        $this->section_plan_DAO = $section_plan_DAO;
    }

    private function getFirstWord($stringVal) {
        return explode(' ', $stringVal)[0];
    }

    // На самом деле ищет в первом слове фамилии, если фамилия состоит из 2х слов.
    private function findStatementByLastName($statements, $lastNameFirstWord) {
        foreach ($statements as $stat) {
            if ($this->getFirstWord($stat['user']->last_name) == $lastNameFirstWord) {
                return $stat;
            }
        }
        return null;
    }

    // Возвращает массив всех $statement'ов, которые не
    // связаны с пользователями, id'шники которых перечислены в
    // массиве $thisUserIdList.
    private function findOthers($statements, $thisUserIdList) {
        $res = [];
        foreach ($statements as $stat) {
            if (!in_array($stat['user']['id'], $thisUserIdList)) {
                $res[] = $stat;
            }
        }
        return $res;
    }

    private function setBgColor($sheet, $cellRange, $color) {
        $sheet->getStyle($cellRange)
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB($color);
    }

    // $isForExam: true для экзаменационной ведомости, false - для зачётной ведомости
    public function getExcelLoadOut($plan, $statements, $file, $isForExam) {
        Excel::load($file, function($doc) use ($plan, $statements, $isForExam) {
            $sheet = $doc->setActiveSheetIndex(0);
            $startRow = 9;
            $row = $startRow;
            $filledUserIdList = [];
            $maxCol = ord('A');
            while (true) {
                $fullName = trim($sheet->getCell("B" . $row));
                if ($fullName == '') {
                    break;
                }
                $lastName = $this->getFirstWord($fullName);
                $stat = $this->findStatementByLastName($statements, $lastName);
                if ($stat === null) {
                    $this->setBgColor($sheet, 'B' . $row, 'FFFF00');
                } else {
                    $filledUserIdList[] = $stat['user']['id'];
                }
                $col = ord('F');
                foreach ($plan->section_plans as $ind => $section_plan) {
                    $sectionResult = $stat == null ? 0 : $stat['sections'][$ind]['total'];
                    $sheet->setCellValue(chr($col) . $row, $sectionResult);
                    $col++;
                }
                $sectionsResult = $stat == null ? 0 : $stat['sections_total'];
                $sheet->setCellValue(chr($col) . $row, $sectionsResult);
                $col++;
                $certified = ($stat == null || !$stat['sections_total_ok']) ? 'н/а' : 'а';
                $sheet->setCellValue(chr($col) . $row, $certified);
                $col++;
                $examResult = $stat == null ? 'Z' : $stat['exams_total'];
                $sheet->setCellValue(chr($col) . $row, $examResult);
                $col++;
                $overallResult = $stat == null ? 'Z' : $stat['summary_total'];
                $sheet->setCellValue(chr($col) . $row, $overallResult);
                $col++;
                $credited = ($stat == null || !$stat['summary_total_ok']) ? 'не зачтено' : 'зачтено';
                $sheet->setCellValue(chr($col) . $row, $credited);
                $col++;
                if ($stat == null) {
                    $markCode = 1;
                } else {
                    if ($isForExam) {
                        $markCode = $stat['mark_rus'];
                    } else {
                        if (!$stat['summary_total_ok']) {
                            $markCode = 2;
                        } else {
                            $markCode = 3;
                        }
                    }
                }
                $sheet->setCellValue(chr($col) . $row, $markCode);
                $col++;
                $markBologna = $stat == null ? 'F' : $stat['mark_bologna'];
                $sheet->setCellValue(chr($col) . $row, $markBologna);
                if ($col > $maxCol) {
                    $maxCol = $col;
                }
                $row++;
            }
            $colForNotIncludedStats = chr($maxCol + 2);
            $notIncludedStatements = $this->findOthers($statements, $filledUserIdList);
            $row = $startRow;
            foreach ($notIncludedStatements as $st) {
                $user = $st['user'];
                $name = "$user->last_name $user->first_name";
                $cellId = $colForNotIncludedStats . $row;
                $sheet->setCellValue($cellId, $name);
                $this->setBgColor($sheet, $cellId, 'FF0000');
                $row++;
            }
        })->store('xlsx', storage_path('app/public/excel'), true);
        $file = storage_path('app/public/excel'). "/file.xlsx";
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );
        return Response::download($file, 'file.xlsx', $headers);
    }

    public function getResultingStatementByGroup($id_group) {
        $users = User::where([['group', '=', $id_group], ['role', '=', 'Студент']])->join('groups', 'groups.group_id', '=', 'users.group')
            ->orderBy('users.last_name', 'asc')->distinct()->get();
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $statement_result = collect([]);
        foreach($users as $user) {
            $statement_result->push($this->getResultingStatementByUser($id_course_plan, $user));
        }

        return $statement_result;
    }

    // returns 'pass_points' and 'work_points'
    private function getSeminarResult($section, $user) {
        $max_work_points = $section['max_seminar_work_point'];
        $max_pass_points = $section['max_seminar_pass_point'];
        $db_res = DB::table('seminar_plans')
            ->leftJoin('seminar_passes', function($join) use ($user) {
                $join->on('seminar_plans.id_seminar_plan', '=', 'seminar_passes.id_seminar_plan')
                    ->where('seminar_passes.id_user', '=', $user->id);
            })
            ->where('seminar_plans.id_section_plan', '=', $section['id_section_plan'])
            ->select(DB::raw('coalesce(SUM(seminar_passes.presence), 0)/COUNT(*) AS pass_points'),
                DB::raw('coalesce(SUM(seminar_passes.work_points), 0) AS work_points'))
            ->first();
        $res = collect([]);
        $res->put('presence_points', $db_res->pass_points * $max_pass_points);
        $res->put('work_points', min($db_res->work_points, $max_work_points));
        return $res;
    }

    // returns number meaning pass_points for lectures in section
    private function getLectureResult($section, $user) {
        $max_pass_points = $section['max_lecture_pass_point'];
        $db_res = DB::table('lecture_plans')
            ->leftJoin('lecture_passes', function($join) use ($user) {
                $join->on('lecture_plans.id_lecture_plan', '=', 'lecture_passes.id_lecture_plan')
                    ->where('lecture_passes.id_user', '=', $user->id);
            })
            ->where('lecture_plans.id_section_plan', '=', $section['id_section_plan'])
            ->select(DB::raw('coalesce(SUM(lecture_passes.presence), 0)/COUNT(*) AS pass_points'))
            ->first();
        $res = $db_res->pass_points * $max_pass_points;
        return $res;
    }

    // returns {
    //   "user": user_info,
    //   "sections": [
    //     {
    //       "section_num": int, // for editing
    //       "controls_max_points": int, // for editing
    //       "controls": [
    //         {
    //           "id": int,          // for editing
    //           "section_num": int, // for editing
    //           "presence": bool,
    //           "points": int,
    //         }
    //       ],
    //       "lecture": int,
    //       "seminar": {
    //         "presence_points": float,
    //         "work_points": int
    //       },
    //       "total": int,
    //       "total_ok": bool
    //     },
    //   ],
    //   "sections_total": int
    //   "sections_total_ok": bool
    //   "exams": [
    //     {
    //        "id": int, // for editing
    //        "presence": bool,
    //        "points": int
    //     }
    //   ],
    //   "exams_total": int,
    //   "exams_total_ok": bool,
    //   "summary_total": int,
    //   "summary_total_ok": bool,
    //   "mark_bologna": string,
    //   "mark_rus": string,
    // }
    public function getResultingStatementByUser($id_course_plan, $user) {
        $course_plan = $this->course_plan_DAO->getCoursePlan($id_course_plan);
        $sections = $course_plan->section_plans;

        $all_works = $this->getAllWorksUser($id_course_plan, $user->id);
        $control_works =$all_works->filter(function ($value, $key)  {
            return $value->is_exam == 0;
        });
        $exam_works = $all_works->filter(function ($value, $key) {
            return $value->is_exam == 1;
        });
        $control_work_groupBy_sections = $this->getControlWorksGroupBySec($control_works);
        $exam_work_groupBy_sections = $this->getExamWorksGroupBySection($exam_works);

        $sections_total = 0;
        $section_with_bad_result_exists = false;
        $sections_result = array();
        foreach ($sections as $section) {
            $total = 0;
            $controls = array();
            $controls_max = 0;
            foreach ($control_work_groupBy_sections[$section->section_num] as $control_work) {
                $presence = $control_work['presence'] == 1;
                $points = $presence ? round($control_work['points'], 0) : 0;
                $total += $points;
                $controls_max += $control_work['max_points'];
                $controls[] = array(
                    'id' => $control_work['id_control_work_pass'],
                    'section_num' => $control_work['section_num'],
                    'presence' => $presence,
                    'points' => $points,
                );
            }
            $lecture = $this->getLectureResult($section, $user);
            $seminar = $this->getSeminarResult($section, $user);
            $total = round($total + $lecture + $seminar['presence_points'] + $seminar['work_points'], 0);
            $ok = $total >= 0.6 * $controls_max;
            if (!$ok) {
                $section_with_bad_result_exists = true;
            }
            $sections_total += $total;
            $sections_result[] = array(
                'section_num' => $section['section_num'],
                'controls_max_points' => $controls_max,
                'controls' => $controls,
                'lecture' => $lecture,
                'seminar' => $seminar,
                'total' => $total,
                'total_ok' => $ok,
            );
        }
        $sections_total_ok = !$section_with_bad_result_exists && $sections_total >= 0.6 * $course_plan->max_semester;

        $exams_total = 0;
        $exams_result = array();
        $exam_with_bad_result_exists = false;
        foreach ($exam_work_groupBy_sections as $exams_by_section) {
            foreach ($exams_by_section as $exam_data) {
                $presence = $exam_data['presence'] == 1;
                $points = $presence ? round($exam_data['points'], 0) : 0;
                $exams_total += $points;
                if ($points < 0.6 * $exam_data['max_points']) {
                    $exam_with_bad_result_exists = true;
                }
                $exams_result[] = array(
                    'id' => $exam_data['id_control_work_pass'],
                    'presence' => $presence,
                    'points' => $points,
                );
            }
        }
        $exams_total_ok = !$exam_with_bad_result_exists && $exams_total >= 0.6 * $course_plan->max_exam;

        $summary_total = $sections_total + $exams_total;
        $summary_total_ok = $sections_total_ok && $exams_total_ok
            && $summary_total >= 0.6 * ($course_plan->max_semester + $course_plan->max_exam);

        $mark_bologna = $summary_total_ok ? Test::calcMarkBologna(100, $summary_total) : 'F';
        $mark_rus = $summary_total_ok ? Test::calcMarkRus(100, $summary_total) : '2';

        return array(
            'user' => $user,
            'sections' => $sections_result,
            'sections_total' => $sections_total,
            'sections_total_ok' => $sections_total_ok,
            'exams' => $exams_result,
            'exams_total' => $exams_total,
            'exams_total_ok' => $exams_total_ok,
            'summary_total' => $summary_total,
            'summary_total_ok' => $summary_total_ok,
            'mark_bologna' => $mark_bologna,
            'mark_rus' => $mark_rus,
        );
    }

    public function getResultControlWorkSections(Collection $control_work_groupBy_sections, $id_user) {
        return $control_work_groupBy_sections->map( function($value, $key) use($id_user) {
            return $this->getResultSectionByNumber($key, $id_user);
        });
    }

    public function getResultSectionByNumber($num_section, $id_user) {
       return ControlWorkPasses::where('id_user', $id_user)
           ->leftJoin('control_work_plans', 'control_work_plans.id_control_work_plan', '=' ,'control_work_passes.id_control_work_plan')
           ->leftJoin('section_plans', 'section_plans.id_section_plan', '=', 'control_work_plans.id_section_plan')
           ->where('section_plans.section_num', '=', $num_section)
           ->get(['control_work_passes.points'])
           ->sum(function ($item) {
               return $item->points;
           });
    }

    public function getExamWorksGroupBySection(Collection $exam_works) {
        $exam_work_groupBy_sections = $exam_works
            ->groupBy('id_section_plan')
            ->sortBy(function ($value, $key) {
                return $key;//значение ключа = id раздела (Экзамена/Зачёта)
            })
            ->map(function ($item) {
                return $item->sortBy('id_control_work_plan');
            });
        return $exam_work_groupBy_sections;
    }

    public function getControlWorksGroupBySec(Collection $control_works) {
        $control_work_groupBy_sections = $control_works
            ->groupBy('section_num')
            ->sortBy(function ($value, $key) {
                return $key;//значение ключа = номер раздела
            })
            ->map(function ($item) {
                return $item->sortBy('id_control_work_plan');
            });
        return $control_work_groupBy_sections;
    }

    public function getAllWorksUser($id_course_plan, $id_user) {
        $all_id_control_work = $this->course_plan_DAO->getAllControlWorks($id_course_plan)
            ->map(function ($item) {
                return $item->id_control_work_plan;
            });
        $all_id_exam_work = $this->course_plan_DAO->getAllExamWorks($id_course_plan)
            ->map(function ($item) {
                return $item->id_control_work_plan;
            });
        $all_id_works = $all_id_control_work->merge($all_id_exam_work);
        $all_works = ControlWorkPasses::where('control_work_passes.id_user',$id_user)
            ->whereIn('control_work_passes.id_control_work_plan',$all_id_works)
            ->leftJoin('control_work_plans', 'control_work_plans.id_control_work_plan', 'control_work_passes.id_control_work_plan')
            ->leftJoin('section_plans', 'section_plans.id_section_plan', 'control_work_plans.id_section_plan')
            ->get(['section_plans.id_section_plan'
                , 'section_plans.section_num'
                , 'section_plans.is_exam'
                , 'control_work_plans.id_control_work_plan'
                , 'control_work_plans.max_points'
                , 'control_work_plans.control_work_plan_name'
                , 'control_work_passes.id_control_work_pass'
                , 'control_work_passes.presence'
                , 'control_work_passes.points'
                , 'control_work_passes.id_user']);
        return $all_works;
    }

    public function getResultWorkSeminar($id_course_plan, $id_user) {
        $all_id_seminar = $this->course_plan_DAO->getAllSeminars($id_course_plan)
            ->map(function ($item) {
                return $item->id_seminar_plan;
            });
        $result_point =  SeminarPasses::whereIn('id_seminar_plan', $all_id_seminar)
            ->where('id_user', $id_user)
            ->get()
            ->sum(function ($item) {
                return $item->work_points;
            });
        return $result_point;
    }

    public function getResultSeminar($id_course_plan, $id_user) {
        $max_seminars =  $this->course_plan_DAO
            ->getCoursePlan($id_course_plan)
            ->max_seminars;
        $all_id_seminar = $this->course_plan_DAO->getAllSeminars($id_course_plan)
            ->map(function ($item) {
                return $item->id_seminar_plan;
            });
        $count_seminar = $all_id_seminar->count();
        $temp_arr = ['max_seminars' => $max_seminars, 'count_seminar' => $count_seminar];
        $result =  SeminarPasses::whereIn('id_seminar_plan', $all_id_seminar)
            ->where('id_user', $id_user)
            ->get()
            ->sum(function ($item) use ($temp_arr){
                return $item->presence * $temp_arr['max_seminars'] / $temp_arr['count_seminar'];
            });
        return $result;
    }

    //Отметка присутствия на контр меропр
    public function markPresent(Request $request){
        $id_control_work_pass = $request->input('id_control_work_pass');
        $is_presence = $request->input('is_presence');
        if ($is_presence == 'true') {
            ControlWorkPasses::where('id_control_work_pass', $id_control_work_pass)
                ->update(['presence' => 1]);
        } else {
            ControlWorkPasses::where('id_control_work_pass', $id_control_work_pass)
                ->update(['presence' => 0]);
        }

    }

    public function resultChange(Request $request){
        $id_control_work_pass = $request->input('id_control_work_pass');
        $control_work_points = $request->input('control_work_points');
        ControlWorkPasses::where('id_control_work_pass', $id_control_work_pass)
            ->update(['points' => $control_work_points]);
    }

    public function getResultChangeValidate(Request $request) {
        $validator = Validator::make($request->toArray(), [
            'control_work_points' => ['required',
                'numeric',
                'between:0,100']
        ]);
        $validator->after(function ($validator) {
            $current_point = $validator->getData()['control_work_points'];
            $id_control_work_pass = $validator->getData()['id_control_work_pass'];
            $max_points = ControlWorkPasses::where('id_control_work_pass', $id_control_work_pass)
                ->leftJoin('control_work_plans', 'control_work_plans.id_control_work_plan', '=',
                    'control_work_passes.id_control_work_plan')
                ->first()->max_points;
            $different = abs($current_point - $max_points);
            if($current_point > $max_points) {
                $validator->errors()->add('exceeded_max_points_control_work',
                    'Сумма баллов превышает Макс балл за контрольное мероприятие (' . $max_points . ') на ' . $different);
            }

        });
        return $validator;
    }

    public function markPresentAll(Request $request) {
        $id_control_work_plan = $request->input('id_control_work_plan');
        $id_group = $request->input('id_group');
        $users_group = User::where('group', '=', $id_group)->get()
            ->map(function ($item) {
                return $item->id;
            });
        ControlWorkPasses::whereIn('id_user', $users_group)
            ->where('id_control_work_plan', '=', $id_control_work_plan)
            ->update(['presence' => 1]);
    }

}