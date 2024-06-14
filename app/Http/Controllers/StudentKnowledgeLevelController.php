<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 29.05.2018
 * Time: 23:27
 */

namespace App\Http\Controllers;


use App\Testing\Result;
use App\Testing\TestTask;
use Illuminate\Http\Request;
use App\User;
use Input;
use Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

    /**
     * This function was previously used to set the knowledge levels of students based on data from three CSV files.
     * Each file contained exam results which were processed to calculate a cumulative score for each student.
     * The scores were then used to update the knowledge level of each student in the database.
     * 
     * Note: As of now, the CSV files are no longer available, and this functionality is deprecated.
     * Alternative methods should be used to set and update students' knowledge levels.
     */
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
                        $marks[$last_name]['sum'] += $this->bolognaToPercent($data[10], substr($data[8], -1));
                        $marks[$last_name]['count']++;
                    }
                    fclose($handle);
                }
            }
            
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

    // /**
    //  * This function calculates the knowledge levels of students based on their test results.
    //  * It retrieves all students with the role 'Студент', iterates through their results,
    //  * and calculates a weighted average score based on the difficulty and discriminant of the questions.
    //  * The calculated knowledge level is then saved to the user's profile.
    //  * Finally, it redirects to the 'students_level' route with a status message indicating successful recalculation.
    //  * 
    //  * Данный метод не используется
    //  */
    // public function calculateKnowledgeLevels() {
    //     $users = User::whereRole('Студент')->get();

    //     foreach ($users as $user) {
    //         $results = Result::where('id', $user->id)->get();
    //         $totalPoints = 0;
    //         $totalWeight = 0;

    //         foreach ($results as $result) {
    //             $testTasks = TestTask::where('id_result', $result->id_result)->get();
    //             foreach ($testTasks as $task) {
    //                 $question = Question::find($task->id_question);
    //                 if ($question) {
    //                     $weight = $question->difficulty * $question->discriminant;
    //                     $totalPoints += $task->points * $weight;
    //                     $totalWeight += $weight;
    //                 }
    //             }
    //         }

    //         $knowledgeLevel = $totalWeight > 0 ? $totalPoints / $totalWeight : 0;
    //         $user->knowledge_level = $knowledgeLevel;
    //         $user->save();
    //     }

    //     return redirect()->route('students_level')->with('status',
    //         'Уровни знаний студентов успешно пересчитаны!');
    // }

    // /**
    //  * This function calculates the knowledge levels of students based on their test results without using adaptive question parameters.
    //  * It retrieves all students with the role 'Студент', iterates through their results,
    //  * and calculates a simple average score.
    //  * The calculated knowledge level is then saved to the user's profile.
    //  * Finally, it redirects to the 'students_level' route with a status message indicating successful recalculation.
    //  */
    // public function calculateSimpleKnowledgeLevels() {
    //     $users = User::whereRole('Студент')->get();
    //     Log::debug('start!');
    //     foreach ($users as $user) {
    //         $results = Result::where('id', $user->id)->get();
    //         $totalPoints = 0;
    //         $totalTasks = 0;

    //         foreach ($results as $result) {
    //             $testTasks = TestTask::where('id_result', $result->id_result)->get();
    //             foreach ($testTasks as $task) {
    //                 $totalPoints += $task->points;
    //                 $totalTasks++;
    //             }
    //         }

    //         // Calculate the average points per task
    //         $averagePoints = $totalTasks > 0 ? $totalPoints / $totalTasks : 0;

    //         // Normalize the knowledge level to be within the range [-3, 3]
    //         // Assuming the range of averagePoints is known and max is MAX_POINTS
    //         $MAX_POINTS = 100; // This should be set according to the actual maximum points possible
    //         $normalizedKnowledgeLevel = ($averagePoints / $MAX_POINTS) * 6 - 3;

    //         // Assign the normalized knowledge level to the user
    //         $user->knowledge_level = $normalizedKnowledgeLevel;
    //         $user->save();
    //     }
    //     Log::debug('done!');
    //     return response()->json(['status' => 'success']);
    // }

    // /**
    //  * This function calculates the knowledge levels of students based on their test results using optimized queries.
    //  * It retrieves all students with the role 'Студент', calculates a simple average score using aggregated queries,
    //  * and updates the knowledge level in a batch operation.
    //  * The calculated knowledge level is then saved to the user's profile.
    //  * Finally, it redirects to the 'students_level' route with a status message indicating successful recalculation.
    //  */
    // public function calculateOptimizedKnowledgeLevels() {
    //     $users = User::whereRole('Студент')->get(['id']);

    //     $userIds = $users->pluck('id');

    //     $results = Result::whereIn('id', $userIds)
    //                      ->join('test_tasks', 'results.id_result', '=', 'test_tasks.id_result')
    //                      ->selectRaw('results.id as user_id, SUM(test_tasks.points) as total_points, COUNT(test_tasks.id_task) as total_tasks')
    //                      ->groupBy('results.id')
    //                      ->get();
    //     $updates = [];
    //     $MAX_POINTS = 100; // This should be set according to the actual maximum points possible

    //     foreach ($results as $result) {
    //         $averagePoints = $result->total_tasks > 0 ? $result->total_points / $result->total_tasks : 0;
    //         $normalizedKnowledgeLevel = ($averagePoints / $MAX_POINTS) * 6 - 3;

    //         $updates[] = [
    //             'id' => $result->user_id,
    //             'knowledge_level' => $normalizedKnowledgeLevel
    //         ];
    //     }

    //     // Batch update users' knowledge levels
    //     foreach ($updates as $update) {
    //         User::where('id', $update['id'])->update(['knowledge_level' => $update['knowledge_level']]);
    //     }

    //     Log::debug('done2!');
    //     return response()->json(['status' => 'success']);
    // }

    public function calculateOptimizedKnowledgeLevelsExactly() {
        $query = "
            SELECT
                last_results.`user_id`,
                AVG(percent) AS percent_knowledge_level,
                AVG(percent) / 100 * 6 - 3 AS knowledge_level
            FROM (
                SELECT
                    r1.id AS `user_id`,
                    r1.id_test,
                    r1.result_date,
                    r1.mark_ru,
                    r1.mark_eu,
                    r1.result,
                    t.total,
                    r1.result * 100.0 / t.total AS percent
                FROM results r1
                JOIN (
                    SELECT id, id_test, MAX(result_date) AS max_date
                    FROM results
                    GROUP BY id, id_test
                ) r2 ON r1.id = r2.id AND r1.id_test = r2.id_test AND r1.result_date = r2.max_date
                JOIN tests t ON r1.id_test = t.id_test
                WHERE
                    r1.result >= 0
                    AND (r1.result * 100.0 / t.total BETWEEN 0 AND 100)
            ) last_results
            GROUP BY last_results.`user_id`
        ";

        $results = DB::select(DB::raw($query));
        // Log::debug($results);

        $userIdsWithResults = [];
        foreach ($results as $result) {
            User::withTrashed()->where('id', $result->user_id)
                ->update(['knowledge_level' => $result->knowledge_level]);
            Log::debug('saved ' . $result->user_id . ' with knowledge level ' . $result->knowledge_level);
            $userIdsWithResults[] = $result->user_id;
        }

        Log::debug($userIdsWithResults);

        // User::withTrashed()... чтобы для удалённых пользователей
        // то же учитывалось
        User::withTrashed()->whereNotIn('id', $userIdsWithResults)
            ->update(['knowledge_level' => null]);

        return response()->json(['status' => 'success']);
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