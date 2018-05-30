<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.05.2018
 * Time: 15:09
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Testing\Question;
use App\Testing\Test;

class AdaptiveTestController extends Controller {
    private $test;

    function __construct(Test $test){
        $this->test = $test;
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
}