<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 22.02.16
 * Time: 2:45
 */

namespace App\Http\Controllers;
use App\Group;
use App\Testing\Fine;
use App\Testing\Result;
use App\Testing\Test;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/** Модуль преподавателя для управления возможностью переписывания тестов студентами */
class TeacherRetestController extends Controller {
    public function index(){
        $users = User::join('groups', 'users.group', '=', 'groups.group_id')
            ->where('groups.archived', '=', 0)
            ->orderBy('users.last_name', 'asc')
            ->select(DB::raw('CONCAT(`users`.`last_name`, " ", `users`.`first_name`) as user_name'))->get();

        $groups = Group::whereArchived(0)
            ->orderBy('group_name', 'asc')
            ->select('group_name')
            ->get();

        $tests = Test::whereArchived(0)
            ->whereOnlyForPrint(0)
            ->whereTestType('Контрольный')
            ->orderBy('test_name', 'asc')
            ->select('test_name')
            ->get();

        $fine_table = Fine::join('users', 'fines.id', '=', 'users.id')
            ->join('groups', 'groups.group_id', '=', 'users.group')
            ->join('tests', 'tests.id_test', '=', 'fines.id_test')
            ->where('groups.archived', '=', 0)
            ->where('tests.test_type', '=', 'Контрольный')
            ->where('tests.only_for_print', '=', 0)
            ->where('groups.archived', '=', 0)
            ->select('fines.id_fine as id_fine',
                     'users.id as id',
                     DB::raw('CONCAT(users.last_name, " ", users.first_name) as user'),
                     'groups.group_name as group',
                     'tests.id_test as id_test',
                     'tests.test_name as test',
                     'fines.fine as fine',
                     'fines.access as access')
            ->get();

        $fines = [];

        foreach ($fine_table as $row) {
            $result = Result::whereId_test($row->id_test)->whereId($row->id)->select('mark_eu')->orderBy('id_result', 'desc')->first()->mark_eu;

            $fine = [];
            $fine['id'] = $row->id_fine;
            $fine['student'] = $row->user;
            $fine['group'] = $row->group;
            $fine['test'] = $row->test;
            $fine['access'] = $row->access;
            $fine['fine'] = Fine::levelToPercent($row->fine);
            $fine['attempts'] = Result::whereId_test($row->id_test)->whereId($row->id)->where('mark_ru', '>=', 0)->count();
            $fine['last_mark'] = preg_replace('/^absent$/', 'Отсутствие', $result);

            array_push($fines, $fine);
        }

        $marks = ['A', 'B', 'C', 'D', 'E', 'F'];

        return view('personal_account.retest', compact('tests', 'users', 'groups', 'marks', 'fines'));
    }

   /** Применение изменений на странице переписывания тестов (возможность прохождения и уровень штрафа) */
    public function change(Request $request){
        for ($i=0; $i < count($request->input('fines')); $i++){
            Fine::whereId_fine($request->input('id')[$i])->update(['fine' => Fine::percentToLevel($request->input('fine-levels')[$i]),
                                                                   'access' => $request->input('fines')[$i]]);
        }
       return redirect()->back();
    }

    /** Завершает выбранные просроченные тесты
     * Завершить тест - Отнять у всех текущих студентов попытку прохождения теста и,
     возможно, добавить записи user-test в таблицу штрафов
     */
    public function finishTest(Request $request){
        $id_group = $request->input('id_group');
        for ($i=0; $i < count($request->input('changes')); $i++){
            if ($request->input('changes')[$i] == true){                                                                //если тест был выбран для завершения
                $id_test = $request->input('id-test')[$i];
                Test::finishTestForGroup($id_test, $id_group);
            }
        }
        return redirect()->back();
    }
} 