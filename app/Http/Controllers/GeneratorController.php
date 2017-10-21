<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.12.15
 * Time: 14:32
 */

namespace App\Http\Controllers;

use App\Mypdf;
use App\Testing\Qtypes\AccordanceTable;
use App\Testing\Qtypes\Definition;
use App\Testing\Qtypes\FillGaps;
use App\Testing\Qtypes\JustAnswer;
use App\Testing\Qtypes\MultiChoice;
use App\Testing\Qtypes\OneChoice;
use App\Testing\Qtypes\Theorem;
use App\Testing\Qtypes\TheoremLike;
use App\Testing\Qtypes\YesNo;
use App\Testing\Question;
use App\Testing\Test;
use App\Testing\TestGeneration\UsualTestGenerator;
use Illuminate\Http\Request;


class GeneratorController extends Controller {

    private function pdfQuestion(Mypdf $fpdf, $id_question, $count, $answered=false){
        $type = Question::whereId_question($id_question)->join('types', 'questions.type_code', '=', 'types.type_code')
                ->first()->type_name;
        switch($type){
            case 'Выбор одного из списка':
                $one_choice = new OneChoice($id_question);
                $one_choice->pdf($fpdf, $count, $answered);
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id_question);
                $multi_choice->pdf($fpdf, $count, $answered);
                break;
            case 'Текстовый вопрос':
                $fill_gaps = new FillGaps($id_question);
                $fill_gaps->pdf($fpdf, $count, $answered);
                break;
            case 'Таблица соответствий':
                $accordance_table = new AccordanceTable($id_question);
                $accordance_table->pdf($fpdf, $count, $answered);
                break;
            case 'Да/Нет':
                $yes_no = new YesNo($id_question);
                $yes_no->pdf($fpdf, $count, $answered);
                break;
            case 'Определение':
                $def = new Definition($id_question);
                $def->pdf($fpdf, $count, $answered);
                break;
            case 'Просто ответ':
                $just = new JustAnswer($id_question);
                $just->pdf($fpdf, $count, $answered);
                break;
            case 'Теорема':
                $theorem = new Theorem($id_question);
                $theorem->pdf($fpdf, $count, $answered);
                break;
            case 'Как теорема':
                $theorem = new TheoremLike($id_question);
                $theorem->pdf($fpdf, $count, $answered);
                break;
        }
    }

    private function headOfPdf(Mypdf $fpdf, $test_name, $variant, $num_tasks){
            $fpdf->AliasNbPages();                                                                                      // для вывода общего числа страниц
            //$fpdf->AddFont('TimesNewRomanPSMT','','times.php');
            $fpdf->AddPage();
            $fpdf->Head($test_name);
            $fpdf->info($variant);                                                                                            // вывод информации о билете
            $fpdf->task_table($num_tasks);                                                                                 // вывод таблицы результатов
    }

    /** удаляет директорию вместе с файлами */
    private function delPdf($dir){
        $temp = opendir( $dir );
        while( $d = readdir( $temp ) ){
            if ($d != '.' && $d != '..'){
                unlink($dir.'/'.$d);
            }
        }
        rmdir($dir);
    }

    /** Скачивание файла */
    private function download($filename){
        header("HTTP/1.1 200 OK");
        header("Connection: close");
        header("Content-Transfer-Encoding: binary");
        header("Content-Type: application/zip");
        header("Content-Length: ".filesize($filename));
        header("Content-Disposition: attachment; filename=".$filename);
        readfile($filename);
    }

    public function index(){
        $tests = [];
        $query = Test::whereArchived(0)
                    ->select('id_test', 'test_name', 'test_type')->get();
        foreach ($query as $test){
            if ($test->test_type != 'Тренировочный'){
                array_push($tests, $test->test_name);
            }
        }
        return view('generator.index', compact('tests'));
    }

    /** Генерирует pdf файлы с тестом с заданным количеством вариантов */
    public function pdfTest(Request $request){
        $question = new Question();
        $test = new Test();

        $test_name = $request->input('test');
        $num_var = $request->input('num-variants');
        $id_test = Test::whereTest_name($test_name)->select('id_test')->first()->id_test;
        $amount = $test->getAmount($id_test);                                                                                // кол-во вопрососв в тесте

        $today =  date("Y-m-d H-i-s");
        $dir = 'archive/pdf_tests/'.Mypdf::translit($test_name).' '.$today;
        mkdir($dir);

        define('FPDF_FONTPATH','C:\wamp\www\uir\public\fonts');
        for ($k = 1; $k <= $num_var; $k++){                                                                             // генерируем необходимое число вариантов
            $fpdf = new Mypdf();
            $answered_fpdf = new Mypdf();
            $this->headOfPdf($fpdf, $test_name, $k, $amount);
            $this->headOfPdf($answered_fpdf, $test_name, $k, $amount);
            $generator = new UsualTestGenerator();
            $generator->buildGraphFromTest(Test::whereId_test($id_test)->first());
            $generator->generate();
            for ($i=0; $i<$amount; $i++){                                                                               // показываем каждый вопрос из теста
                $id = $generator->chooseQuestion();
                $this->pdfQuestion($fpdf, $id, $i+1);
                $this->pdfQuestion($answered_fpdf, $id, $i+1, true);
            }
            $fpdf->Output($dir.'/variant'.$k.'.pdf', 'F');
            $answered_fpdf->Output($dir.'/answered_variant'.$k.'.pdf', 'F');
        }

        $zip = Mypdf::pdfToZip($dir);                                                                                   // создаем архив
        $this->delPdf($dir);                                                                                            // удаляем созданную папку с тестами
        $this->download($zip);                                                                                          // скачать архив
    }
} 