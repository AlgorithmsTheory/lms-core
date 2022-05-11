<?php
namespace App\Testing\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Input;
use Session;
use App\Http\Controllers\Emulators\EmulatorController;

class Turing extends QuestionType implements Checkable {
    const type_code = 12;

    function __construct($id_question){
        parent::__construct($id_question);
    }

    private function setAttributes(Request $request) {
        $options = $this->getOptions($request);
        $title = $this->getTitleWithImage($request);

        $variants = $request->input('variants-in')[0];
        for ($i=1; $i<count($request->input('variants-in')); $i++){
            $variants = $variants.';'.$request->input('variants-in')[$i];
        }
        $answer = "";

        $eng_variants = $request->input('variants-out')[0];
        for ($i=1; $i<count($request->input('variants-out')); $i++){
            $eng_variants = $eng_variants.';'.$request->input('variants-out')[$i];
        }
        $eng_answer = "";

        return ['title' => $title['ru_title'], 'variants' => $variants,
                'answer' => $answer, 'points' => $options['points'], 'difficulty' => $options['difficulty'],
                'discriminant' => $options['discriminant'], 'guess' => $options['guess'],
                'pass_time' => $options['pass_time'],
                'control' => $options['control'], 'translated' => $options['translated'],
                'section_code' => $options['section'], 'theme_code' => $options['theme'], 'type_code' => $options['type'],
                'title_eng' => $title['eng_title'], 'variants_eng' => $eng_variants, 'answer_eng' => $eng_answer];
    }

    public  function add(Request $request) {
        $data = $this->setAttributes($request);
        Question::insert(array('title' => $data['title'], 'variants' => $data['variants'],
                        'answer' => $data['answer'], 'points' => $data['points'], 'difficulty' => $data['difficulty'],
                        'discriminant' => $data['discriminant'], 'guess' => $data['guess'], 'pass_time' => $data['pass_time'],
                        'control' => $data['control'], 'translated' => $data['translated'],
                        'section_code' => $data['section_code'], 'theme_code' => $data['theme_code'], 'type_code' => $data['type_code'],
                        'title_eng' => $data['title_eng'], 'variants_eng' => $data['variants_eng'], 'answer_eng' => $data['answer_eng']));
    }

    public function edit() {
        $question = Question::whereId_question($this->id_question)->first();
        $count = count(explode(";", $question->variants));
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;
        $images = explode("::", $question->title);
        $variants = explode(";", $question->variants);
        $eng_variants = explode(";", $question->variants_eng);
        return array('question' => $question, 'count' => $count, 'type_name' => $type_name,
                     'images' => $images, 'variants-in' => $variants, 'variants-out' => $eng_variants);
    }

    public function update(Request $request) {
        $data = $this->setAttributes($request);
        Question::whereId_question($this->id_question)->update(
        array('title' => $data['title'], 'variants' => $data['variants'],
              'answer' => $data['answer'], 'points' => $data['points'], 'difficulty' => $data['difficulty'],
              'discriminant' => $data['discriminant'], 'guess' => $data['guess'], 'pass_time' => $data['pass_time'],
              'control' => $data['control'], 'translated' => $data['translated'],
              'section_code' => $data['section_code'], 'theme_code' => $data['theme_code'], 'type_code' => $data['type_code'],
              'title_eng' => $data['title_eng'], 'variants_eng' => $data['variants_eng'], 'answer_eng' => $data['answer_eng'])
        );
    }

    public function show($count) {
        $view = 'tests.show12';
        $array = array('view' => $view, 'arguments' =>
            array(
                'text' => explode('::',$this->text),
                // Число нажатий на кнопку "Проверить работу"
                "debug_counter" => 0,
                // Число нажатий на кнопку "Проверить синтаксис"
                'check_syntax_counter' => 0,
                // Число нажатий на кнопку "Запустить"
                'run_counter' => 0,
                "type" => self::type_code,
                "id" => $this->id_question,
                "count" => $count));
        return $array;
    }

    public function check($array) {
        Log::debug('array of check');
        Log::debug($array);
        $debug_counter = $array[0];
        $check_syntax_counter = $array[1];
        $run_counter = $array[2];
        $data = $array[3];

        $parse = $this->variants;

        $variantsIn = explode(";", $parse);
        $parse = $this->eng_variants;
        $variantsOut = explode(";", $parse);

        $test_seq = ['input_word' => $variantsIn, 'output_word' => $variantsOut];
        
        $array = EmulatorController::MTCheckSequence($data, $test_seq);
        
        //--------------------------------------------------------------

        $total_cycle = $array[2];
		$sequences_true = $array[0];
		$sequences_all = $array[1];
        $mark = $sequences_true == $sequences_all ? 'Верно' : 'Неверно';
        $right_percent = $sequences_true / $sequences_all;
        $fee_percent = 0.15*$debug_counter + 0.05*$check_syntax_counter + 0.10*$run_counter;
        if ($fee_percent > 0.5) {
            $fee_percent = 0.5;
        }
        $score_percent = $right_percent - $fee_percent;
        if ($score_percent < 0) {
            $score_percent = 0;
        }
        $max_scores = $this->points;
        $scores = $score_percent * $max_scores;

		$data = array('mark'=>$mark, 'score' => $scores,
            'id' => $this->id_question, 'points' => $this->points,
            'right_percent' => $right_percent,
                'choice' => ['debug_counter' => $debug_counter, 'check_syntax_counter' => $check_syntax_counter,
                    'run_counter' => $run_counter,
                    'sequences_true' => $sequences_true, 'sequences_all' => $sequences_all,
                    'fee_percent' => $fee_percent, 'score'=>$scores, 'total_cycle'=>$total_cycle]);
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false, $paper_savings=false) {
        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Напишите решение задачи на Машине Тьюринга</td></tr>';
        $html .= '<tr><td>'.$this->text.'</td></tr></table>';
        if ($paper_savings) {
            $height_tr = QuestionType::PAPER_SAVING_HEIGHT_ANSWER;
        } else {
            $height_tr = $this::ORIGIN_HEIGHT_ANSWER;
        }
        if ($answered == false) {
            $html .= '<p>Ваш алгоритм:</p>';
            $html .= '<table border="1" style="border-collapse: collapse;" width="100%">
                        <tr><td height="' . $height_tr . '"></td></tr>
                      </table><br>';
        }
        
        $fpdf->WriteHTML($html);
    }
	
	public function evalGuess() {
        return 0.0;
    }
}
