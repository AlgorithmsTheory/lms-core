<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 13:49
 */
namespace App\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Type;
use Illuminate\Http\Request;
use Input;
use Session;
class OneChoice extends QuestionType {
    const type_code = 1;
    function __construct($id_question){
        parent::__construct($id_question);
    }

    private function setAttributes(Request $request){
        $options = $this->getOptions($request);
        $parse_text = preg_split('/\[\[|\]\]/', $request->input('title'));                                              //части текста вопроса без [[ ]]
        $eng_parse_text = preg_split('/\[\[|\]\]/', $request->input('eng-title'));                                      //части текста вопроса на английском без [[ ]]

        $destinationPath = 'img/questions/title/';                                                                      //путь для картинки
        $input_images = Input::file();
        for ($i = 1; $i < count($input_images['text-images']); $i++){
            $extension = $input_images['text-images'][$i-1]->getClientOriginalExtension();                              //получаем расширение файла
            $fileName = rand(11111, 99999) . '.' . $extension;                                                          //случайное имя картинки
            $input_images['text-images'][$i-1]->move($destinationPath, $fileName);                                      //перемещаем картинку
            $parse_text[2*$i-1] = '::'.$destinationPath.$fileName.'::';                                                 //заменить каждуый старый файл на новый
            $eng_parse_text[2*$i-1] = '::'.$destinationPath.$fileName.'::';
        }
        $title = '';
        foreach ($parse_text as $part){                                                                                 //собираем все в строку
            $title .= $part;
        }
        $eng_title = '';
        foreach ($eng_parse_text as $eng_part){                                                                         //собираем все в строку для английского текста
            $eng_title .= $eng_part;
        }

        $variants = $request->input('variants')[0];
        for ($i=1; $i<count($request->input('variants')); $i++){
            $variants = $variants.';'.$request->input('variants')[$i];
        }
        $answer = $request->input('variants')[0];

        $eng_variants = $request->input('eng-variants')[0];
        for ($i=1; $i<count($request->input('eng-variants')); $i++){
            $eng_variants = $eng_variants.';'.$request->input('eng-variants')[$i];
        }
        $eng_answer = $request->input('eng-variants')[0];

        return ['title' => $title, 'variants' => $variants,
                'answer' => $answer, 'points' => $options['points'],
                'control' => $options['control'], 'translated' => $options['translated'],
                'section_code' => $options['section'], 'theme_code' => $options['theme'], 'type_code' => $options['type'],
                'title_eng' => $eng_title, 'variants_eng' => $eng_variants, 'answer_eng' => $eng_answer];
    }

    public  function add(Request $request){
        $data = $this->setAttributes($request);
        Question::insert(array('title' => $data['title'], 'variants' => $data['variants'],
                        'answer' => $data['answer'], 'points' => $data['points'],
                        'control' => $data['control'], 'translated' => $data['translated'],
                        'section_code' => $data['section_code'], 'theme_code' => $data['theme_code'], 'type_code' => $data['type_code'],
                        'title_eng' => $data['title_eng'], 'variants_eng' => $data['variants_eng'], 'answer_eng' => $data['answer_eng']));
    }

    public function edit(){
        $question = Question::whereId_question($this->id_question)->first();
        $count = count(explode(";", $question->variants));
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;
        $images = explode("::", $question->title);
        $variants = explode(";", $question->variants);
        $eng_variants = explode(";", $question->variants_eng);
        return array('question' => $question, 'count' => $count, 'type_name' => $type_name,
                     'images' => $images, 'variants' => $variants, 'eng_variants' => $eng_variants);
    }

    public function update(Request $request){
        $data = $this->setAttributes($request);
        Question::whereId_question($this->id_question)->update(
        array('title' => $data['title'], 'variants' => $data['variants'],
              'answer' => $data['answer'], 'points' => $data['points'],
              'control' => $data['control'], 'translated' => $data['translated'],
              'section_code' => $data['section_code'], 'theme_code' => $data['theme_code'], 'type_code' => $data['type_code'],
              'title_eng' => $data['title_eng'], 'variants_eng' => $data['variants_eng'], 'answer_eng' => $data['answer_eng'])
        );
    }

    public function show($count){
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $new_variants = $this->question->mixVariants($variants);
        $view = 'tests.show1';
        $array = array('view' => $view, 'arguments' => array('text' => explode('::',$this->text), "variants" => $new_variants, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }
    public function check($array){
        if ($array[0] == $this->answer){
            $score = $this->points;
            $right_percent = 100;
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array[0], 'right_percent' => $right_percent);
        }
        else {
            $score = 0;
            $right_percent = 0;
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array[0], 'right_percent' => $right_percent);
        }
        //echo $score.'<br>';
        if ($score != $this->points){
            $right_percent = 0;
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array[0], 'right_percent' => $right_percent);
        }
        //echo $score.'<br>';
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false){
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
            $new_variants = $this->question->mixVariants($variants);
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

} 