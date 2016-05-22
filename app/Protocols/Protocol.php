<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 20.05.16
 * Time: 2:04
 */

namespace App\Protocols;

use App\Mypdf;
use App\User;

abstract class Protocol {
    const PROTOCOL_PATH = 'archive/protocols/';
    public $test;
    public $user;
    public $group;
    public $filename;
    public $html;

    public function __construct($test, $user, $html){
        $this->setTest($test);
        $query = User::whereId($user)->select('first_name', 'last_name', 'group')->first();
        $this->user = $query->first_name.' '.$query->last_name;
        $this->group = $query->group;
        $now =  date("Y-m-d H-i-s");
        $this->filename = Mypdf::translit($this->user).' '.$now.'.pdf';
        $this->html = $html;
    }

    /** Шапка протокола */
    private function header(Mypdf $pdf){
        $html = '<table style="margin: auto;"><tr><td style="text-align: center;">Национальный исследовательский ядерный университет "МИФИ"</td></tr>';
        $html .= '<tr><td style="text-align: center;">ДМ: Теория алгоритмов и сложность вычислений</td></tr>';
        $html .= '<tr><td style="text-align: center;">Протокол</td></tr></table>';
        $html .= '<p>ФИО студента: '.$this->user.'</p>';
        $html .= '<p>Группа: '.$this->group.'</p>';
        $html .= '<p>Название теста: '.$this->test.'</p>';
        $html .= '<p>Дата прохождения: '.$now =  date("Y-m-d").'</p>';
        $pdf->AliasNbPages();                                                                                           // для вывода общего числа страниц
        $pdf->AddPage();
        $pdf->WriteHTML($html);
    }

    /** если каталога с путем $path нет, создает этот каталог. В люом случае возвращает путь в этот каталог */
    private function makeDir($path){
        if (!file_exists($path)){
            mkdir($path);
        }
        return $path.'/';
    }

    /** Полный путь до файла */
    private function pathToFile(){
        $dir = $this->setBaseDir();                                                                                     //устанавливаем базовый каталог в зависимоти от типа (тест, эмулятор и тд)
        $dir = $this->makeDir($dir.Mypdf::translit($this->test));                                                                        //переходим  каталог теста
        $dir = $this->makeDir($dir.$this->group);                                                                       //переходим в каталог группы
        $dir = $dir.$this->filename;                                                                                    //прибавляем само имя файла
        return $dir;
    }

    /** Определяет название мероприятия */
    abstract function setTest($id_test);

    /** Устанавливает базовую директорию в зависимости от типа мероприятия (тест, эмулятор и тд) */
    abstract function setBaseDir();

    /** Создание pdf-протокола */
    public function create(){
        $pdf = new Mypdf();
        $this->header($pdf);                                                                                            //создаем шапку
        $pdf->WriteHTML($this->html);                                                                                   //записываем тело
        $path = $this->pathToFile();                                                                                    //вычисляем путь к файлу
        $pdf->Output($path, 'F');                                                                                       //сохраняем файл
    }

} 