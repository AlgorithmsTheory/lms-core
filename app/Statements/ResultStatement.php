<?php


namespace App\Statements;
use App\Statements\Passes\LecturePasses;
use App\Statements\Passes\SeminarPasses;
use App\Statements\Plans\ControlWorkPlan;
use App\Statements\Plans\SectionPlan;
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
use Storage;
use Validator;
class ResultStatement {
    private $course_plan_DAO;
    private $section_plan_DAO;
    public function __construct(CoursePlanDAO $course_plan_DAO,SectionPlanDAO $section_plan_DAO)
    {
        $this->course_plan_DAO = $course_plan_DAO;
        $this->section_plan_DAO = $section_plan_DAO;
    }
    public function getSeminarsBySections($id_course_plan, $id_user) {
        $all_id_seminar = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan)
            ->map(function ($section) {
                return  $section->map(function ($seminar) {
                    return ($seminar->id_seminar_plan);
                });

            });
        $all_seminars = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan);
        $count_seminars = $all_seminars->map(function($section){
            return $section->count();
        });
        $sem_pres = collect([]);
        $all_id_seminar->map(function($section) use($id_user,$sem_pres){
            $sectionRes = SeminarPasses::whereIn('id_seminar_plan', $section)
                ->where('id_user', $id_user)
                ->get();
            $sem_pres->push($sectionRes);
        });
        return $sem_pres;
    }

    public function getLecturesBySections($id_course_plan, $id_user) {
        $max_lecrures =  $this->course_plan_DAO
            ->getCoursePlan($id_course_plan);
        $all_lecture = $this->course_plan_DAO->getAllLecturesBySection($id_course_plan);
        $all_id_lecture = $this->course_plan_DAO->getAllLecturesBySection($id_course_plan)
            ->map(function ($section) {
                return  $section->map(function ($lecture) {
                    return ($lecture->id_lecture_plan);
                });

            });
        $lect_pres = collect([]);
        $all_id_lecture->map(function($section) use($id_user,$lect_pres){
            $sectionRes = LecturePasses::whereIn('id_lecture_plan', $section)
                ->where('id_user', $id_user)
                ->get();
            $lect_pres->push($sectionRes);
        });
        $count_lecture = $all_lecture->map(function($section){
            return $section->count();
        });
        return $lect_pres;

    }

    public function getLecSemBySections($id_course_plan, $id_user) {
        $max_lecrures =  $this->course_plan_DAO
            ->getCoursePlan($id_course_plan);
        $all_lecture = $this->course_plan_DAO->getAllLecturesBySection($id_course_plan);
        $all_id_lecture = $this->course_plan_DAO->getAllLecturesBySection($id_course_plan)
            ->map(function ($section) {
                return  $section->map(function ($lecture) {
                    return ($lecture->id_lecture_plan);
                });

            });
        $all_id_seminar = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan)
            ->map(function ($section) {
                return  $section->map(function ($seminar) {
                    return ($seminar->id_seminar_plan);
                });

            });

        $all_seminars = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan);
        $all_count_seminars = 0;
        $count_seminars = $all_seminars->map(function($section)use ($all_count_seminars){
            return $section->count();
        });
        foreach($count_seminars as $s){
            $all_count_seminars += $s;
        }
        $all_count_lecture = 0;
        $count_lecture = $all_lecture->map(function($section) use ($all_count_lecture){
            return $section->count();
        });
        foreach($count_lecture as $l){
            $all_count_lecture += $l;
        }
        $lect_pres = collect([]);
        $all_id_lecture->map(function($section) use($id_user,$lect_pres){
            $sectionRes = LecturePasses::whereIn('id_lecture_plan', $section)
                ->where('id_user', $id_user)
                ->get();
            $lect_pres->push($sectionRes);
        });
        $max_seminars = $max_lecrures["max_seminars"];
        $max_lecrtures= $max_lecrures["max_lecrures"];
        //echo $max_lecrures;
        $sem_pres = collect([]);
        $all_id_seminar->map(function($section) use($id_user,$sem_pres){
            $sectionRes = SeminarPasses::whereIn('id_seminar_plan', $section)
                ->where('id_user', $id_user)
                ->get();
            $sem_pres->push($sectionRes);
        });

        $seminarWorks = $this->getWorkSeminarBySection($id_course_plan, $id_user, $all_seminars);
        $sWs = collect();
        foreach ($seminarWorks as $seminar){
            $sum = 0;
            foreach ($seminar as $semBal){
                $sum += $semBal['points'];
            }
            $sWs -> push($sum);
        }
        $max_temp_lectures = $count_lecture->map(function($section) use ($max_lecrures){
            return $max_lecrures;
        });
        $sp = SectionPlan::where('id_course_plan', $id_course_plan)->get();
        $maxes = collect();
        $sp->map(function($section) use($maxes){
            $maxes->push($section['max_seminar_pass_point']);
        });
        $lectIter = 0;
        $lect_sum = collect();
        foreach ($lect_pres as $lect){
            $sum = 0;
            foreach ($lect as $lecture){
                $sum += $lecture->presence;
            }
            $lect_sum->push($sum);
            $lectIter += 1;
        }
        $semIter = 0;
        $sem_sum = collect();
        foreach ($sem_pres as $lect){
            $sum = 0;
            foreach ($lect as $lecture){
                $sum += $lecture->presence;
            }
            $sem_sum->push($sum);
            $semIter += 1;
        }
        $j = 0;
        $sec = collect([]);
        $ballFor1PL =  $max_lecrtures /  $all_count_lecture;
        $ballFor1PS =  $max_seminars / $all_count_seminars;
        while ($j < count($sem_pres)){
            if (($count_seminars[$j] + $count_lecture[$j]) != 0) {
                $sec->push([($sem_sum[$j]  * $ballFor1PS), ($lect_sum[$j] * $ballFor1PL)]);
            }
            else{
                $sec->push([0,0]);
            }
            $j += 1;
        }
        $res = collect([]);
        $res->put('semsum',$sem_sum);
        $res->put('lectsum',$lect_sum);
        $res->put('csem',$count_seminars);
        $res->put('clec',$count_lecture);
        $res->put('maxes',$maxes);
        $res->put("allsem", $all_seminars);
        $res->put("sec", $sec);
        //echo $ballFor1PL ;
        return $res;
    }
    public function getWorkSeminarBySection($id_course_plan, $id_user, $all_seminars) {
        $all_id_seminar = $this->course_plan_DAO->getAllSeminars($id_course_plan)
            ->map(function ($item) {
                return $item->id_seminar_plan;
            });

        $result_point =  SeminarPasses::whereIn('id_seminar_plan', $all_id_seminar)
            ->where('id_user', $id_user)
            ->get();


        $result = collect([]);
        $all_seminars->map(function($seminar_by_section) use($result_point){
            $seminar_by_section->map(function ($seminar_u) use ($result_point){
                $seminar_u['points'] = '0';
                $result_point->map(function ($seminarWork) use ($seminar_u){
                    if ($seminarWork['id_seminar_plan'] == $seminar_u['id_seminar_plan']){
                        $seminar_u['points']  = $seminarWork['work_points'];
                    }
                });
            });

        });

        return $all_seminars;
    }
    public function getResultBySections($id_course_plan, $id_user) {
        $max_lecrures =  $this->course_plan_DAO
            ->getCoursePlan($id_course_plan);
        $all_lecture = $this->course_plan_DAO->getAllLecturesBySection($id_course_plan);
        $all_id_lecture = $this->course_plan_DAO->getAllLecturesBySection($id_course_plan)
            ->map(function ($section) {
                return  $section->map(function ($lecture) {
                    return ($lecture->id_lecture_plan);
                });

            });
        $all_id_seminar = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan)
            ->map(function ($section) {
                return  $section->map(function ($seminar) {
                    return ($seminar->id_seminar_plan);
                });

            });
        $all_seminars = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan);
        $count_seminars = $all_seminars->map(function($section){
            return $section->count();
        });

        $count_lecture = $all_lecture->map(function($section){
            return $section->count();
        });

        $lect_pres = collect([]);
        $all_id_lecture->map(function($section) use($id_user,$lect_pres){
            $sectionRes = LecturePasses::whereIn('id_lecture_plan', $section)
            ->where('id_user', $id_user)
            ->get();
            $lect_pres->push($sectionRes);
        });

        $sem_pres = collect([]);
        $all_id_seminar->map(function($section) use($id_user,$sem_pres){
            $sectionRes = SeminarPasses::whereIn('id_seminar_plan', $section)
                ->where('id_user', $id_user)
                ->get();
            $sem_pres->push($sectionRes);
        });

        $seminarWorks = $this->getWorkSeminarBySection($id_course_plan, $id_user, $all_seminars);

        $sections = $this->section_plan_DAO->getSectionPlansByCourse($id_course_plan);
        $o = 0;
        $sWs = collect();
        foreach ($seminarWorks as $seminar){
            $sum = 0;
            foreach ($seminar as $semBal){
                    $sum += $semBal['points'];

            }
            if ($sum < $sections[$o]['max_seminar_work_point']) {
                $sWs->push($sum);
            }
            else{
                $sWs->push($sections[$o]['max_seminar_work_point']);
            }
            $o += 1;
        }
        $max_temp_lectures = $count_lecture->map(function($section) use ($max_lecrures){
            return $max_lecrures;
        });
        $sp = SectionPlan::where('id_course_plan', $id_course_plan)->get();
        $maxes = collect();
        $sp->map(function($section) use($maxes){
            $maxes->push($section['max_seminar_work_point']);
        });
        $lectIter = 0;
        $lect_sum = collect();
        foreach ($lect_pres as $lect){
            $sum = 0;
            foreach ($lect as $lecture){
                $sum += $lecture->presence;
            }
            $lect_sum->push($sum);
            $lectIter += 1;
        }
        $semIter = 0;
        $sem_sum = collect();
        foreach ($sem_pres as $lect){
            $sum = 0;
            foreach ($lect as $lecture){
                $sum += $lecture->presence;
            }
            $sem_sum->push($sum);
            $semIter += 1;
        }
        $j = 0;
        $sec = collect();
        while ($j < count($sem_pres)){
            if (($count_seminars[$j] + $count_lecture[$j]) != 0) {
                $sec->push($maxes[$j] * ($lect_sum[$j] + $sem_sum[$j]) / ($count_seminars[$j] + $count_lecture[$j]) + $sWs[$j]);
            }
            else{
                $sec->push(0);
            }
            $j += 1;
        }
        $j = 0;
        while ($j < count($sec)){
            if ($sec[$j] > $maxes[$j]){
                $sec[$j] = $maxes[$j];
            }
            $j += 1;
        }
        return $sec;
    }
    public function getExcelLoadOut($course_plan,$statement_result, $file){
        //$sectionsCount = count($course_plan['section_plans']);
        //return $statement_result;
        //return $course_plan['max_exam'] ;
        $userResultSections = collect();
        foreach ($statement_result as $user_state){
            $userResultSections->push($user_state['sec_sum']);
        };
        $sectionCount = $userResultSections[0]->count();
        //return $statement_result[0]['maximumsBySections'][0];
        Excel::load($file, function($doc) use ($sectionCount,$statement_result, $userResultSections,$course_plan) {
            $res = "";
            $sheet = $doc->setActiveSheetIndex(0);
            $studentStartNum = 12;
            $e = $studentStartNum;
            $count = 0;
            while ($sheet->getCell("B" . $e) != ""){
                $count += 1;
                $e+= 1;
            }
            $costilNum = "B";
            $costilName = "D";
            $costilZachetka = "H";
            $adress = array("A","B","C", "D", "E", "F", "G", "H", "I","J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG");

            $u = 0;
            $costil = array(4,2,2,2,2,2,2);
            $startSectionNum = 8;
            $sumBallSections = 0;
            for ($i = 0; $i < $sectionCount; $i++) {
                    $sheet->setCellValue($adress[$startSectionNum + $u] . ($studentStartNum-1), round($statement_result[0]['maximumsBySections'][$i],0) . '('. round($statement_result[0]['maximumsBySections'][$i] * 0.6,0) . ")");
                    $u = $u + $costil[$i];
                    $sumBallSections += $statement_result[0]['maximumsBySections'][$i];
            }
            $point = $startSectionNum + $u;
            $StartSumBallForSections = $point + 2;
            $sheet->setCellValue($adress[$StartSumBallForSections] . 11, round($sumBallSections,0));

            $OtmetkaRazdel = $StartSumBallForSections +2;

            $Balls1Ball = $OtmetkaRazdel +1;
            $sheet->setCellValue($adress[$Balls1Ball] . 11, $course_plan['max_exam'] . '('. round($course_plan['max_exam'] * 0.6,0) . ")");

            $Balls2Itog = $Balls1Ball +2;
            $sheet->setCellValue($adress[$Balls2Itog] . 11, ($course_plan['max_exam'] + $sumBallSections) . '('. (round($course_plan['max_exam'] + $sumBallSections* 0.6,0)  ) . ")");

            for ($j = 0; $j < $count; $j++){
                $name = $sheet->getCell($costilName . $studentStartNum);
                $name = mb_strtolower($name);
                $userNum = 0;
                $u = 0;

                foreach ($statement_result as $user_statement){
                    $usrLN = $user_statement['user']->last_name;
                    $usrFN = mb_str_split($user_statement['user']->first_name)[0];
                    $usrLN = mb_strtolower($usrLN);

                    $res = $res . strpos($name, $usrLN);
                    if (strpos($name, $usrLN) !== false){

                        $sheet->setCellValue('D'.(100 + $j), $usrLN);
                        $u = 0;
                        $startSectionNum = 8;
                        $sumRazdel = 0;
                        for ($i = 0; $i < $sectionCount; $i++) {
                                $sheet->setCellValue($adress[$startSectionNum + $u] . $studentStartNum, round($userResultSections[$userNum][$i],0) );
                                $sumRazdel += $userResultSections[$userNum][$i];
                                $u = $u + $costil[$i];
                        }
                        $point = $startSectionNum + $u;
                        $StartSumBallForSections = $point;
                        $sheet->setCellValue($adress[$StartSumBallForSections] . $studentStartNum, round($sumRazdel,0));

                        $soIter = 0;
                        $isAttestated = true;
                        while ($soIter < count($userResultSections[$userNum])){
                            if ($userResultSections[$userNum][$soIter] < $user_statement['minimumsBySections'][$soIter]){
                                $isAttestated = false;
                            }
                            $soIter += 1;
                        }
                        $OtmetkaRazdel = $StartSumBallForSections +2;
                        if($isAttestated){
                            $sheet->setCellValue($adress[$OtmetkaRazdel] . $studentStartNum,  "а");
                        }
                        else{
                            $sheet->setCellValue($adress[$OtmetkaRazdel] . $studentStartNum,  "н/а");
                        }




                        $Balls1Ball = $OtmetkaRazdel +1;
                        $sheet->setCellValue($adress[$Balls1Ball] . $studentStartNum, round($user_statement['sum_result_section_exam_work'],0));

                        $Balls2Itog = $Balls1Ball +2;
                        $sheet->setCellValue($adress[$Balls2Itog] . $studentStartNum,  round($user_statement['absolutefullsum'],0));


                        $Balls3TekstOtmetka = $Balls2Itog +2;
                        $Balls4KodOtmetka = $Balls3TekstOtmetka +2;

                        if ( $user_statement['markBologna'] == "F"){
                            $sheet->setCellValue($adress[$Balls3TekstOtmetka] . $studentStartNum,   "не зачтено");
                            $sheet->setCellValue($adress[$Balls4KodOtmetka] . $studentStartNum,  "2");
                        }else{
                            $sheet->setCellValue($adress[$Balls3TekstOtmetka] . $studentStartNum,  "зачтено");
                            $sheet->setCellValue($adress[$Balls4KodOtmetka] . $studentStartNum,  "3");
                        }




                        $Balls6markBologna = $Balls4KodOtmetka +5;
                        $sheet->setCellValue($adress[$Balls6markBologna] . $studentStartNum,  $user_statement['markBologna']);
                        break;
                    }
                    else
                    {
                        $u = 0;
                        $startSectionNum = 8;

                        for ($i = 0; $i < $sectionCount; $i++) {
                                $sheet->setCellValue($adress[$startSectionNum + $u] . $studentStartNum, "0" );
                                $u = $u + $costil[$i];

                        }
                        $point = $startSectionNum + $u;
                        $StartSumBallForSections = $point;
                        $sheet->setCellValue($adress[$StartSumBallForSections] . $studentStartNum, "0");

                        $OtmetkaRazdel = $StartSumBallForSections +2;
                        $sheet->setCellValue($adress[$OtmetkaRazdel] . $studentStartNum,  "н/а");

                        $Balls1Ball = $OtmetkaRazdel +1;
                        $sheet->setCellValue($adress[$Balls1Ball] . $studentStartNum, "Z");

                        $Balls2Itog = $Balls1Ball +2;
                        $sheet->setCellValue($adress[$Balls2Itog] . $studentStartNum,  "Z");


                        $Balls3TekstOtmetka = $Balls2Itog +2;
                        $sheet->setCellValue($adress[$Balls3TekstOtmetka] . $studentStartNum,   "не зачтено");


                        $Balls4KodOtmetka = $Balls3TekstOtmetka +2;
                        $sheet->setCellValue($adress[$Balls4KodOtmetka] . $studentStartNum, "1");

                        $Balls6markBologna = $Balls4KodOtmetka +5;
                        $sheet->setCellValue($adress[$Balls6markBologna] . $studentStartNum,  "F");

                    }
                    $userNum += 1;

                }
                $studentStartNum+= 1;
            }

        })->store('xlsx', storage_path('app/public/excel'), true);
        //PDF file is stored under project/public/download/info.pdf
        $file = storage_path('app/public/excel'). "/file.xlsx";
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );
        return Response::download($file, 'file.xlsx', $headers);
    }

    public function getExcelLoadOutEx($course_plan,$statement_result, $file){
        //$sectionsCount = count($course_plan['section_plans']);
        //return $statement_result;
        //return $course_plan['max_exam'] ;
        $userResultSections = collect();
        foreach ($statement_result as $user_state){
            $userResultSections->push($user_state['sec_sum']);
        };
        $sectionCount = $userResultSections[0]->count();
        //return $statement_result[0]['maximumsBySections'][0];
        Excel::load($file, function($doc) use ($sectionCount,$statement_result, $userResultSections,$course_plan) {
            $res = "";
            $sheet = $doc->setActiveSheetIndex(0);
            $studentStartNum = 12;
            $e = $studentStartNum;
            $count = 0;
            while ($sheet->getCell("B" . $e) != ""){
                $count += 1;
                $e+= 1;
            }
            $costilNum = "B";
            $costilName = "D";
            $costilZachetka = "H";
            $adress = array("A","B","C", "D", "E", "F", "G", "H", "I","J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG");

            $u = 0;
            $costil = array(4,2,2,2,2,2,2);
            $startSectionNum = 8;
            $sumBallSections = 0;
            for ($i = 0; $i < $sectionCount; $i++) {
                $sheet->setCellValue($adress[$startSectionNum + $u] . ($studentStartNum-1), round($statement_result[0]['maximumsBySections'][$i],0) . '('. round($statement_result[0]['maximumsBySections'][$i] * 0.6,0) . ")");
                $u = $u + $costil[$i];
                $sumBallSections += $statement_result[0]['maximumsBySections'][$i];
            }
            $point = $startSectionNum + $u;
            $StartSumBallForSections = $point + 2;
            $sheet->setCellValue($adress[$StartSumBallForSections] . 11, round($sumBallSections,0));

            $OtmetkaRazdel = $StartSumBallForSections +2;

            $Balls1Ball = $OtmetkaRazdel +1;
            $sheet->setCellValue($adress[$Balls1Ball] . 11, $course_plan['max_exam'] . '('. round($course_plan['max_exam'] * 0.6,0) . ")");

            $Balls2Itog = $Balls1Ball +2;
            $sheet->setCellValue($adress[$Balls2Itog] . 11, ($course_plan['max_exam'] + $sumBallSections) . '('. (round($course_plan['max_exam'] + $sumBallSections* 0.6,0)  ) . ")");

            for ($j = 0; $j < $count; $j++){
                $name = $sheet->getCell($costilName . $studentStartNum);
                $name = mb_strtolower($name);
                $userNum = 0;
                $u = 0;

                foreach ($statement_result as $user_statement){
                    $usrLN = $user_statement['user']->last_name;
                    $usrFN = mb_str_split($user_statement['user']->first_name)[0];
                    $usrLN = mb_strtolower($usrLN);

                    $res = $res . strpos($name, $usrLN);
                    if (strpos($name, $usrLN) !== false){

                        $sheet->setCellValue('D'.(100 + $j), $usrLN);
                        $u = 0;
                        $startSectionNum = 8;
                        $sumRazdel = 0;
                        for ($i = 0; $i < $sectionCount; $i++) {
                            $sheet->setCellValue($adress[$startSectionNum + $u] . $studentStartNum, round($userResultSections[$userNum][$i],0) );
                            $sumRazdel += $userResultSections[$userNum][$i];
                            $u = $u + $costil[$i];
                        }
                        $point = $startSectionNum + $u;
                        $StartSumBallForSections = $point;
                        $sheet->setCellValue($adress[$StartSumBallForSections] . $studentStartNum, round($sumRazdel,0));

                        $soIter = 0;
                        $isAttestated = true;
                        while ($soIter < count($userResultSections[$userNum])){
                            if ($userResultSections[$userNum][$soIter] < $user_statement['minimumsBySections'][$soIter]){
                                $isAttestated = false;
                            }
                            $soIter += 1;
                        }
                        $OtmetkaRazdel = $StartSumBallForSections +2;
                        if($isAttestated){
                            $sheet->setCellValue($adress[$OtmetkaRazdel] . $studentStartNum,  "а");
                        }
                        else{
                            $sheet->setCellValue($adress[$OtmetkaRazdel] . $studentStartNum,  "н/а");
                        }




                        $Balls1Ball = $OtmetkaRazdel +1;
                        $sheet->setCellValue($adress[$Balls1Ball] . $studentStartNum, round($user_statement['sum_result_section_exam_work'],0));

                        $Balls2Itog = $Balls1Ball +2;
                        $sheet->setCellValue($adress[$Balls2Itog] . $studentStartNum,  round($user_statement['absolutefullsum'],0));


                        $Balls3TekstOtmetka = $Balls2Itog +2;
                        if ( $user_statement['markBologna'] == "F"){
                            $sheet->setCellValue($adress[$Balls3TekstOtmetka] . $studentStartNum,   "неудовл");
                        }else{
                            if (round($user_statement['absolutefullsum'],0) >= 60 && round($user_statement['absolutefullsum'],0) <= 69){
                                $sheet->setCellValue($adress[$Balls3TekstOtmetka] . $studentStartNum,  "удовл");
                            }else{
                                if (round($user_statement['absolutefullsum'],0) >= 70 && round($user_statement['absolutefullsum'],0) <= 89){
                                    $sheet->setCellValue($adress[$Balls3TekstOtmetka] . $studentStartNum,  "хор");
                                }
                                else{
                                    if (round($user_statement['absolutefullsum'],0) >= 90 ){
                                        $sheet->setCellValue($adress[$Balls3TekstOtmetka] . $studentStartNum,  "отл");
                                    }
                                }
                            }
                        }


                        $Balls4KodOtmetka = $Balls3TekstOtmetka +2;
                        $sheet->setCellValue($adress[$Balls4KodOtmetka] . $studentStartNum,  $user_statement['markRus']);

                        $Balls6markBologna = $Balls4KodOtmetka +5;
                        $sheet->setCellValue($adress[$Balls6markBologna] . $studentStartNum,  $user_statement['markBologna']);
                        break;
                    }
                    else
                    {
                        $u = 0;
                        $startSectionNum = 8;

                        for ($i = 0; $i < $sectionCount; $i++) {
                            $sheet->setCellValue($adress[$startSectionNum + $u] . $studentStartNum, "0" );
                            $u = $u + $costil[$i];

                        }
                        $point = $startSectionNum + $u;
                        $StartSumBallForSections = $point;
                        $sheet->setCellValue($adress[$StartSumBallForSections] . $studentStartNum, "0");

                        $OtmetkaRazdel = $StartSumBallForSections +2;
                        $sheet->setCellValue($adress[$OtmetkaRazdel] . $studentStartNum,  "н/а");

                        $Balls1Ball = $OtmetkaRazdel +1;
                        $sheet->setCellValue($adress[$Balls1Ball] . $studentStartNum, "Z");

                        $Balls2Itog = $Balls1Ball +2;
                        $sheet->setCellValue($adress[$Balls2Itog] . $studentStartNum,  "Z");


                        $Balls3TekstOtmetka = $Balls2Itog +2;
                        $sheet->setCellValue($adress[$Balls3TekstOtmetka] . $studentStartNum,   "не удовл.");


                        $Balls4KodOtmetka = $Balls3TekstOtmetka +2;
                        $sheet->setCellValue($adress[$Balls4KodOtmetka] . $studentStartNum, "1");

                        $Balls6markBologna = $Balls4KodOtmetka +5;
                        $sheet->setCellValue($adress[$Balls6markBologna] . $studentStartNum,  "F");

                    }
                    $userNum += 1;

                }
                $studentStartNum+= 1;
            }

        })->store('xlsx', storage_path('app/public/excel'), true);
        //PDF file is stored under project/public/download/info.pdf
        $file = storage_path('app/public/excel'). "/file.xlsx";
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );
        return Response::download($file, 'file.xlsx', $headers);
    }

    //Вывод итоговой ведомости  по группе
    public function getStatementByGroup($id_group) {
        $users = User::where([['group', '=', $id_group], ['role', '=', 'Студент']])->join('groups', 'groups.group_id', '=', 'users.group')
            ->orderBy('users.last_name', 'asc')->distinct()->get();
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $statement_result = collect([]);
        foreach($users as $user) {
            $statement_result->push($this->getStatementByUser($id_course_plan, $user));
        }

        return $statement_result;
    }

    public function getStatementByUserId($id_course_plan, $user_id) {
        $user = User::whereId($user_id)->get()[0];
        return $this->getStatementByUser($id_course_plan, $user);
    }

    private function calcSectionTotals($course_plan, $sections, $section_total_array) {
        $control_work_points_array = collect();
        foreach ($sections as $section){
            $control_work_points = 0;
            foreach ($section['control_work_plans'] as $control_work){
                // if ($control_work['control_work_plan_type'] == "WRITING"){
                $control_work_points += $control_work['max_points'];
                // }
            }
            $control_work_points_array->push($control_work_points);
        }

        $all_ok = 1;
        $sec_ok = collect();
        $i = 0;
        while ($i < count($section_total_array)){
            if ($section_total_array[$i] < $control_work_points_array[$i] * 0.6) {
                $all_ok = 0;
                $sec_ok->push(0);
            } else {
                $sec_ok->push(1);
            }
            $i += 1;
        }
        if ($section_total_array->sum() < $course_plan->max_semester * 0.6) {
            $all_ok = 0;
        }

        return array(
            'all_ok' => $all_ok,
            'sec_ok' => $sec_ok,
        );
    }

    //Вывод ведомости по id_user
    public function getStatementByUser($id_course_plan, $user) {

        $course_plan = $this->course_plan_DAO->getCoursePlan($id_course_plan);
        $sp = SectionPlan::where('id_course_plan', $id_course_plan)
            ->where('is_exam', '=', 0)
            ->get()
            ->sortBy('section_num');

        // Подсчет посещаемости семинаров
        $seminar_ids_for_each_section = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan)
            ->map(function ($seminars_for_section) {
                return  $seminars_for_section->map(function ($seminar) {
                    return ($seminar->id_seminar_plan);
                });
            });
        $all_seminars = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan);
        $seminars_by_section = collect([]);

        $seminar_ids_for_each_section->map(function($seminar_ids_for_section) use($user,$seminars_by_section){
            $seminars_of_section = SeminarPasses::whereIn('id_seminar_plan', $seminar_ids_for_section)
                ->where('id_user', $user->id)
                ->get();
            $seminars_by_section->push($seminars_of_section);
        });
        $seminar_attended_max_points = collect();
        $sp->map(function($section) use($seminar_attended_max_points){
            $seminar_attended_max_points->push($section['max_seminar_pass_point']);
        });

        $i = 0;
        $seminar_attended_points = collect();
        foreach ($seminars_by_section as $seminars_of_section){
            $sum = 0;
            $c = 0;
            foreach ($seminars_of_section as $seminar){
                $sum += $seminar->presence;
                $c += 1;
            }
            $seminar_attended_points->push($sum/$c*$seminar_attended_max_points[$i]);
            $i += 1;
        }

        // Подсчет баллов за работу на семинарах с лимитом на максимум
        $seminarWorks = $this->getWorkSeminarBySection($id_course_plan, $user->id, $all_seminars);
        $maxesW = collect();
        $seminar_work_points = collect();
        $sections = $this->section_plan_DAO->getSectionPlansByCourse($id_course_plan);
        $o = 0;
        foreach ($seminarWorks as $seminar){
            $sum = 0;
            foreach ($seminar as $semBal){
                $sum += $semBal['points'];
            }
            $maxesW->push($sections[$o]['max_seminar_work_point']);
            $seminar_work_points->push($sum);
            $o += 1;
        }
        $ind = 0;
        foreach($seminar_work_points as $sec){
            if ($sec > $maxesW[$ind]){
                $seminar_work_points[$ind] = $maxesW[$ind];
            }
            $ind += 1;
        }

        // Подсчет количества баллов за посещение лекций
        $maxesLP = collect();
        $sp->map(function($section) use($maxesLP){
            $maxesLP->push($section['max_lecture_pass_point']);
        });
        $lect_pres = collect([]);
        $all_id_lectures2 = $this->course_plan_DAO->getAllLecturesBySection($id_course_plan)
            ->map(function ($section) {
                return  $section->map(function ($lecture) {
                    return ($lecture->id_lecture_plan);
                });

            });
        $all_id_lectures2->map(function($section) use($user,$lect_pres){
            $sectionRes = LecturePasses::whereIn('id_lecture_plan', $section)
                ->where('id_user', $user->id)
                ->get();
            $lect_pres->push($sectionRes);
        });
        $lect_sum = collect();
        $i = 0;
        $lecture_points = collect();
        foreach ($lect_pres as $lect){
            $sum = 0;
            $c = 0;
            foreach ($lect as $lecture){
                $sum += $lecture->presence;
                $c += 1;
            }
            $lect_sum->push($sum);
            $lecture_points->push($sum/$c*$maxesLP[$i]);
            $i += 1;
        }

        $all_works = $this->getAllWorksUser($id_course_plan, $user->id);
        $control_works =$all_works->filter(function ($value, $key)  {
            return $value->is_exam == 0;
        });
        $exam_works = $all_works->filter(function ($value, $key) {
            return $value->is_exam == 1;
        });
        $control_work_groupBy_sections = $this->getControlWorksGroupBySec($control_works);
        $exam_work_groupBy_sections = $this->getExamWorksGroupBySection($exam_works);
        $result_control_work_sections = $this->getResultControlWorkSections($control_work_groupBy_sections, $user->id);
        $result_exam_work_sections = $this->getResultExamWorkSections($exam_work_groupBy_sections, $user->id);
        $sum_result_section_control_work = $result_control_work_sections->sum();
        $sum_result_section_exam_work = $result_exam_work_sections->sum();
        $result_lecture = $this->getResultLecture($id_course_plan, $user->id);
        $result_seminar = $this->getResultSeminar($id_course_plan, $user->id);
        $result_work_seminar = $this->getResultWorkSeminar($id_course_plan, $user->id);

        // Общая сумма за разделы
        $all_sections_total = 0;
        // Получение общей суммы за разделы И суммы по каждому разделу
        $section_total_array = collect();
        $i = 0;
        while ($i < count($seminar_attended_points)) {
            $section_total = $seminar_attended_points[$i] + $seminar_work_points[$i] + $lecture_points[$i]
                    + $result_control_work_sections->get($i+1);
            $section_total_array->push($section_total);
            $all_sections_total += $section_total;
            $i += 1;
        }

        $sec_info = $this->calcSectionTotals($course_plan, $sp, $section_total_array);
        $all_ok = $sec_info['all_ok'];
        $sec_ok = $sec_info['sec_ok'];


        // Получение абсолютной суммы
        $abssum1 = 0;
        $abssum1 += $all_sections_total;
        $abssum1 += $sum_result_section_exam_work;
        if ($abssum1 > 100){
            $abssum1 = 100;
        }
        // С прошлых версий, в этой сам алгоритм расчета не был изменен
        $markRus = Test::calcMarkRus(100, $abssum1);
        $markBologna = Test::calcMarkBologna(100, $abssum1);

        $user_statement_result = collect([]);

        // Добавленное
        $user_statement_result->put('ballsBySectionsPass', $seminar_attended_points);
        $user_statement_result->put('ballsBySectionsWorks', $seminar_work_points);
        $user_statement_result->put('ball_lection_passes', $lecture_points);

        $user_statement_result->put('fullsum', $all_sections_total);
        $user_statement_result->put('absolutefullsum', $abssum1);
        $user_statement_result->put('all_ok',  $all_ok);
        $user_statement_result->put('sec_ok',  $sec_ok);
        $user_statement_result->put('sec_sum', $section_total_array);

        // Оставшееся с прошлых версий
        $user_statement_result->put('control_work_groupBy_sections', $control_work_groupBy_sections);
        $user_statement_result->put('user',  $user);
        $user_statement_result->put('result_lecture', $result_lecture);
        $user_statement_result->put('result_seminar', $result_seminar);
        $user_statement_result->put('result_work_seminar', $result_work_seminar);
        $user_statement_result->put('sum_result_section_exam_work', $sum_result_section_exam_work);
        $user_statement_result->put('markRus', $markRus);
        $user_statement_result->put('markBologna', $markBologna);
        $user_statement_result->put('exam_work_groupBy_sections', $exam_work_groupBy_sections);

        return $user_statement_result;
    }

    public function getSumResultSectionControlWork($id_course_plan,$id_user) {
        $all_works = $this->getAllWorksUser($id_course_plan, $id_user);
        $control_works =$all_works->filter(function ($value, $key)  {
            return $value->is_exam == 0;
        });
        $control_work_groupBy_sections = $this->getControlWorksGroupBySec($control_works);
        $result_control_work_sections = $this->getResultControlWorkSections($control_work_groupBy_sections, $id_user);
        return $result_control_work_sections->sum();
    }

    public function getSumResultSectionExamWork($id_course_plan, $id_user) {
        $all_works = $this->getAllWorksUser($id_course_plan, $id_user);
        $exam_works =$all_works->filter(function ($value, $key)  {
            return $value->is_exam == 1;
        });
        $exam_work_groupBy_sections = $this->getExamWorksGroupBySection($exam_works);
        $result_exam_work_sections = $this->getResultExamWorkSections($exam_work_groupBy_sections, $id_user);
        return $result_exam_work_sections->sum();
    }

    public function getResultExamWorkSections(Collection $exam_work_groupBy_sections, $id_user) {
        return $exam_work_groupBy_sections->map( function($value, $key) use($id_user) {
            return $this->getResultSectionById($key, $id_user);
        });
    }

    public function getResultSectionById($id_section, $id_user) {
        return ControlWorkPasses::where('id_user', $id_user)
            ->leftJoin('control_work_plans', 'control_work_plans.id_control_work_plan', '=' ,'control_work_passes.id_control_work_plan')
            ->leftJoin('section_plans', 'section_plans.id_section_plan', '=', 'control_work_plans.id_section_plan')
            ->where('section_plans.id_section_plan', '=', $id_section)
            ->get(['control_work_passes.points'])
            ->sum(function ($item) {
                return $item->points;
            });
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
    public function getResultWorkSeminarBySections($id_course_plan, $id_user) {
        $all_id_seminar = $this->course_plan_DAO->getAllSeminars($id_course_plan)
            ->map(function ($item) {
                return $item->id_seminar_plan;
            });
        $result_point =  SeminarPasses::whereIn('id_seminar_plan', $all_id_seminar)
            ->where('id_user', $id_user)
            ->get();

        return $result_point;
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

    public function getResultLecture($id_course_plan, $id_user) {
        return  $max_lecrures =  $this->course_plan_DAO
            ->getCoursePlan($id_course_plan)
            ->max_lecrures;
        $all_id_lecture = $this->course_plan_DAO->getAllLectures($id_course_plan)
            ->map(function ($item) {
                return $item->id_lecture_plan;
            });
        $count_lecture = $all_id_lecture->count();
        $temp_arr = ['max_lecrures' => $max_lecrures, 'count_lecture' => $count_lecture];
        $result =  LecturePasses::whereIn('id_lecture_plan', $all_id_lecture)
            ->where('id_user', $id_user)
            ->get()
            ->sum(function ($item) use ($temp_arr){
                return $item->presence * $temp_arr['max_lecrures'] / $temp_arr['count_lecture'];
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