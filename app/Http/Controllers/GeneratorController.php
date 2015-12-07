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
use Illuminate\Http\Request;
use ZipArchive;

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

    /** должна упаковывать полученную папку в архив и отправлять пользователю, затем стирать папку и наверное оставлять архив
     * @param $dir
     * директория, в которой лежат файлы этого теста без слеша
     * @return bool возвращает true, если архив удачно создан
     */
    private function pdfToZip($dir){
        $zip = new ZipArchive;
        if ($zip -> open($dir.'.zip', ZipArchive::CREATE) === TRUE)
        {
            $temp = opendir( $dir );
            while( $d = readdir( $temp ) ){
                if ($d != '.' && $d != '..'){
                    $zip->addFile( $dir.'/'.$d, $d);
                }
            }
            $zip -> close();
            return $dir.'.zip';
        }
        else return false;
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
        header("Content-Disposition: attachment; filename=test.zip");

        readfile($filename);
    }

    public function index(){
        $tests = [];
        $query = Test::select('id_test', 'test_name', 'test_type')->get();
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
        $query = Test::whereTest_name($test_name)->select('amount', 'id_test')->first();
        $id_test = $query->id_test;
        $amount = $query->amount;                                                                                       // кол-во вопрососв в тесте
        $num_var = $request->input('num-variants');

        $today =  date("Y-m-d H-i-s");
        $dir = 'download/pdf_tests/'.$today;
        mkdir($dir);

        define('FPDF_FONTPATH','C:\wamp\www\uir\public\fonts');
        for ($k = 1; $k <= $num_var; $k++){                                                                             // генерируем необходимое число вариантов
            $fpdf = new Mypdf();
            $fpdf->AliasNbPages();                                                                                      // для вывода общего числа страниц
            $fpdf->AddFont('TimesNewRomanPSMT','','times.php');
            $fpdf->AddPage();
            $fpdf->Head($test_name);
            $fpdf->info($k);                                                                                            // вывод информации о билете
            $fpdf->task_table($amount);                                                                                 // вывод таблицы результатов

            $test_controller = new TestController($test);
            $question_controller = new QuestionController($question);
            $ser_array = $question_controller->prepareTest($id_test);                                                   // плдготавливаем тест
            for ($i=0; $i<$amount; $i++){                                                                               // показываем каждый вопрос из теста
                $id = $question_controller->chooseQuestion($ser_array);
                if (!$test_controller->rybaTest($id)){                                                                  //проверка на вопрос по рыбе
                    return view('no_access');
                };
                $this->pdfQuestion($fpdf, $id, $i+1);
                $fpdf->Ln(10);
            }
            $fpdf->Output(iconv('utf-8', 'windows-1251', $dir.'/variant'.$k.'.pdf'), 'F');
        }

        $zip = $this->pdfToZip($dir);                                                                                   // создаем архив
        $this->delPdf($dir);                                                                                            // удаляем созданную папку с тестами
        $this->download($zip);                                                                                          // скачать архив
    }
} 