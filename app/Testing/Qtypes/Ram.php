<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 13:49
 */
namespace App\Testing\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Type;
use App\Emulators\TestsequenceRam;
use App\Emulators\TasksRam;
use Illuminate\Http\Request;
use Input;
use Session;
class Ram extends QuestionType implements Checkable {
    const type_code = 15;

    function __construct($id_question){
        parent::__construct($id_question);
    }

    private function setAttributes(Request $request) {
        $options = $this->getOptions($request);
        $title = $this->getTitleWithImage($request);
		$task_id = $request->input('task_id');

        return ['title' => $title['ru_title'], 'variants' => $task_id, 
                'points' => $options['points'], 'difficulty' => $options['difficulty'],
                'discriminant' => $options['discriminant'], 'guess' => $options['guess'],
                'pass_time' => $options['pass_time'],
                'control' => $options['control'], 'translated' => $options['translated'],
                'section_code' => $options['section'], 'theme_code' => $options['theme'], 'type_code' => $options['type'],
                'title_eng' => $title['eng_title'] ];
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
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;
        $images = explode("::", $question->title);
        $task_id = $question->variants;
        return array('question' => $question, 'type_name' => $type_name,
                     'images' => $images, 'task_id' => $task_id);
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
        $task_id = $this->variants;
		$task = TasksRam::where('task_id', $task_id)->get()[0]['description'];
		$test_seq = TestsequenceRam::where('task_id', $task_id)->get();
        $view = 'tests.show15';
        $array = array('view' => $view, 'arguments' => array('text' => explode('::',$this->text), "task_id" => $task_id, "task" => $task, "test_seq" => $test_seq, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function check($array) {
		$debug_counter = $array[0];
		$sequences_true = $array[1];
		$sequences_all = $array[2];
		$score = 0;
		
		if($sequences_true == $sequences_all){
			$mark = 'Верно';
		}
		else{
			$mark = 'Неверно';
		}
		
		$right_percent = ($sequences_true * 1.0) / ($sequences_all * 1.0) * 100;
		$score = $right_percent - $debug_counter;
		
		$data = array('mark'=>$mark, 'score'=>$score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => 0, 'right_percent' => $right_percent);
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false) {
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Выберите один вариант ответа</td></tr>';
        $html .= '<tr><td>'.$this->text.'</td></tr></table>';

        $html .= '<table border="1" style="border-collapse: collapse;" width="100%">';
        if ($answered){                                                                                                 // пдф с ответами
            $answer = $this->answer;
            $new_variants = Session::get('saved_variants_order');
            foreach ($new_variants as $var){
                $html .= '<tr>';
                if ($answer == $var)
                    $html .= '<td width="5%" align="center">+</td><td width="80%">'.$var.'</td>';
                else
                    $html .= '<td width="5%"></td><td width="80%">'.$var.'</td>';
                $html .= '</tr>';
            }
            Session::forget('saved_variants_order');
        }
        else {                                                                                                          // без ответов
            $new_variants = Question::mixVariants($variants);
            Session::put('saved_variants_order', $new_variants);
            foreach ($new_variants as $var){
                $html .= '<tr>';
                $html .= '<td width="5%"></td><td width="80%">'.$var.'</td>';
                $html .= '</tr>';
            }
        }
        $html .= '</table><br>';
        $fpdf->WriteHTML($html);
    }
	
	public function evalGuess() {
        return 0.1;
    }
}
