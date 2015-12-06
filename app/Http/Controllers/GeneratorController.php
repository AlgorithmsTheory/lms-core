<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.12.15
 * Time: 14:32
 */

namespace App\Http\Controllers;

use Anouar\Fpdf\Fpdf;
use App\Mypdf;
use App\Qtypes\AccordanceTable;
use App\Qtypes\FillGaps;
use App\Qtypes\MultiChoice;
use App\Qtypes\OneChoice;
use App\Qtypes\YesNo;
use App\Question;
use App\Test;

class GeneratorController extends Controller {

    private function pdfQuestion(Mypdf $fpdf, $id_question, $count){
        $question = new Question();
        $question_controller = new QuestionController($question);
        $decode = $question_controller->getCode($id_question);
        $type = $decode['type'];
        switch($type){
            case 'Выбор одного из списка':
                $one_choice = new OneChoice($id_question);
                $one_choice->pdf($fpdf, $count);
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id_question);
                $multi_choice->pdf($fpdf, $count);
                break;
            case 'Текстовый вопрос':
                $fill_gaps = new FillGaps($id_question);
                $fill_gaps->pdf($fpdf, $count);
                break;
            case 'Таблица соответствий':
                $accordance_table = new AccordanceTable($id_question);
                $accordance_table->pdf($fpdf, $count);
                break;
        }
    }

    public function index(){
        return view('generator.index');
    }

    /** Главный метод: гененрирует полотно вопросов на странице тестов */
    public function pdfTest($id_test){
        $question = new Question();
        $test = new Test();
        $query = $test->whereId_test($id_test)->select('amount', 'test_name')->first();

        $amount = $query->amount;                                                                                       // кол-во вопрососв в тесте
        $test_name = $query->test_name;                                                                                 // название теста

        define('FPDF_FONTPATH','C:\wamp\www\uir\public\fonts');                                                         // очевидно, что на сервере это не прокатит
        $fpdf = new Mypdf();
        $fpdf->AliasNbPages();                                                                                          // для вывода общего числа страниц
        $fpdf->AddFont('TimesNewRomanPSMT','','times.php');
        $fpdf->AddPage();
        $fpdf->Head($test_name);
        $fpdf->info(1);                                                                                                 // вывод информации о билете
        $fpdf->task_table($amount);                                                                                     // вывод таблицы результатов

        $test_controller = new TestController($test);
        $question_controller = new QuestionController($question);
        $ser_array = $question_controller->prepareTest($id_test);
        for ($i=0; $i<$amount; $i++){
            $id = $question_controller->chooseQuestion($ser_array);
            if (!$test_controller->rybaTest($id)){                                                                      //проверка на вопрос по рыбе
                return view('no_access');
            };
            $this->pdfQuestion($fpdf, $id, $i+1);
            $fpdf->Ln(10);
        }
        $fpdf->Output();
        exit;
    }
} 