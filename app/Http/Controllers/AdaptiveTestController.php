<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.05.2018
 * Time: 15:09
 */

namespace App\Http\Controllers;


use App\Testing\Result;
use App\Testing\TestGeneration\AdaptiveTestGenerator;
use App\Testing\TestTask;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Testing\Question;
use App\Testing\Test;
use View;

class AdaptiveTestController extends Controller {
    private $test;

    function __construct(Test $test){
        $this->test = $test;
    }

    /** Show prepare view with self-estimation form */
    public function prepare($id_test) {
        $marks = ['A', 'B', 'C', 'D(хор)', 'D(удвл)', 'E', 'F'];
        return view('adaptive_tests.prepare', compact('marks', 'id_test'));
    }

    /** Init test params, generate graph, create session, redirect to first question */
    public function init(Request $request, $id_test) {
        $expected_mark = $request->input('expected-mark')[0];
        $student_id = Auth::user()['id'];
        $generator = new AdaptiveTestGenerator($expected_mark, $id_test);
        $generator->generate(Test::whereId_test($id_test)->first());
        $new_result_id = Result::max('id_result') + 1;
        Result::insert(['id_result' => $new_result_id, 'id_test' => $id_test, 'id' => $student_id]);
        $request->session()->put('adaptive_test_'.$student_id, serialize($generator));
        $first_question = $generator->chooseQuestion();
        return redirect()->route('show_adaptive_test', $first_question);
    }

    /** Choose question */
    private function getNextQuestionResponse(AdaptiveTestGenerator $test_instance, Question $question, $id_question) {
        $current_question_number = $test_instance->getCurrentQuestionNumber();
        $show_data = $question->show($id_question, $current_question_number, true);
        $question_widget = View::make($show_data['view'], $show_data['arguments']);

        $current_time = date_create();
        $int_left_time = $test_instance->getCurrentQuestionEndTime() - date_format($current_time, 'U');
        $left_min =  ($int_left_time > 0) ? floor($int_left_time/60) : 0;
        $left_sec = ($int_left_time > 0) ? $int_left_time % 60 : 0;

        $widgetListView = View::make('adaptive_tests.show_question',
            compact('current_question_number', 'left_min', 'left_sec'))
            ->with('question_widget', $question_widget);
        return new Response($widgetListView);
    }

    /** Show question */
    public function showQuestion(Request $request, $id_question) {
        $question = Question::whereId_question($id_question)->first();
        $student_id = Auth::user()['id'];

        $serialized_test = $request->session()->get('adaptive_test_'.$student_id);
        $test_instance = unserialize($serialized_test);
        $response = $this->getNextQuestionResponse($test_instance, $question, $id_question);
        return $response;
    }

    /** Check question and redirect to next question or finish page */
    public function checkQuestion(Request $request) {
        $student_id = Auth::user()['id'];
        $serialized_test = $request->session()->get('adaptive_test_'.$student_id);
        $test_instance = unserialize($serialized_test);

        $array = [];
        // TODO: get well-formed array from question form for next check

        $question = new Question();
        $check_data = $question->check($array);

        $test_instance->setRightFactorAfterCheck($check_data['right_percent'] / 100);
        TestTask::insert(['points' => $check_data['score'], 'id_question' => $check_data['id'], 'id_result' => $test_instance->getIdResult()]);

        $next_question_id = $test_instance->chooseQuestion();
        if ($next_question_id == -1) {
            return redirect()->route('result_adaptive_test');
        }
        $response = $this->getNextQuestionResponse($test_instance, $question, $next_question_id);
        return $response;
    }

    /** Show page with results */
    public function showResults() {
        
    }

    public function dropTest(Request $request) {
        $student_id = Auth::user()['id'];
        $request->session()->remove('adaptive_test_'.$student_id);
        return redirect('home');
    }

    public function params() {
        return view('adaptive_tests.params');
    }

    public function evalParams(Request $request) {
        $params = $request->input('param');
        foreach ($params as $param) {
            if ($param == 'difficulty') {
                $questions = Question::where('section_code', '>', 0)
                    ->whereRaw("type_code in (select type_code from types where only_for_print = 0)")
                    ->select('id_question')->get();
                foreach($questions as $question) {
                    $difficulty = $question->evalDifficulty($question->id_question);
                    Question::whereId_question($question->id_question)->update(['difficulty' => $difficulty]);
                }
            }
            if ($param == 'discriminant') {
                $questions = Question::where('section_code', '>', 0)
                    ->whereRaw("type_code in (select type_code from types where only_for_print = 0)")
                    ->select('id_question')->get();
                foreach($questions as $question) {
                    $discriminant = $question->evalDiscriminant($question->id_question);
                    Question::whereId_question($question->id_question)->update(['discriminant' => $discriminant]);
                }
            }
        }
        return view('adaptive_tests.params');
    }

    public function reEvalDifficulty(Request $request) {
        $id_question = $request->input('id_question');
        $question = Question::whereId_question($id_question)->first();
        return $question->evalDifficulty($id_question);
    }

    public function reEvalDiscriminant(Request $request) {
        $id_question = $request->input('id_question');
        $question = Question::whereId_question($id_question)->first();
        return $question->evalDiscriminant($id_question);
    }
}