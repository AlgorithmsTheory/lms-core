<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 29.05.2018
 * Time: 23:27
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use Input;
use Response;

class StudentKnowledgeLevelController extends Controller {
    const LEVEL_STATEMENTS_TEMP_DIR = 'download/knowledge_level/';
    private $user;

    function __construct(User $user){
        $this->user = $user;
    }

    public function index() {
        return view("personal_account.knowledge_level");
    }

    public function indexWithErrors($error) {
        return view("personal_account.knowledge_level", compact('error'));
    }

    public function setLevel(Request $request) {
        if($request->ajax()) {
            $statements_files = Input::file('file');
            if (count($statements_files) != 3) {
                $error = 'Необходимо загрузить три различных CSV файла с оценками!';
                return Response::json($error, 400);
            }

            $i = 0;
            $filenames = [];
            foreach ($statements_files as $file) {
                $filename = $file->getClientOriginalName() . '_' . ++$i;
                $filenames[$i] = $filename;
                $file->move($this::LEVEL_STATEMENTS_TEMP_DIR, $filename);
            }

            $marks = [];
            foreach ($filenames as $filename) {
                if (($handle = fopen($this::LEVEL_STATEMENTS_TEMP_DIR . $filename, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if ($data[3] != 'Экзамены') continue;
                        // parse "СОРОКИН С.В.\r\n to СОРОКИН
                        $last_name = explode('"', explode(' ', $data[2])[0])[0];
                        if ($last_name == 'ЕНИКЕЕВ') {
                            $a = 5;
                        }
                        $marks[$last_name]['sum'] += $this->bolognaToPercent($data[10], substr($data[8], -1));
                        $marks[$last_name]['count']++;
                    }
                    fclose($handle);
                }
            }

            $current_year = date('Y');
            foreach ($marks as $name => $student) {
                $last_name_in_lower = mb_strtolower($name);
                $user_id = $this->user->where('last_name', 'like', '%'.$last_name_in_lower.'%')
                                        ->where('year', '=', 2017)
                                        ->whereRole('Студент')
                                        ->select('id')->first()->id;
                $this->user->whereId($user_id)->update(
                    ['knowledge_level' => $this->evalKnowledgeLevel($student['sum'], $student['count'])]);
            }
        }
        return redirect()->route('students_level');
    }

    private function bolognaToPercent($bologna_mark, $usual_mark) {
        switch ($bologna_mark) {
            case 'A':
                return 90;
            case 'B':
                return 85;
            case 'C':
                return 75;
            case 'D':
                if ($usual_mark == '4') return 70;
                return 65;
            case 'E':
                return 60;
            default:
                return 60;
        }
    }

    private function evalKnowledgeLevel($points, $number) {
        return 1/5 * $points / $number - 15;
    }
}