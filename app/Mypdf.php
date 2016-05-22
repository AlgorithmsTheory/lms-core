<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.12.15
 * Time: 18:08
 */

namespace App;

use ZipArchive;

class Mypdf extends \mPDF{
    const MAX_COL = 15;

    /** шапка певого листа
     @name название теста
     */
    function Head($name){
        $html = '<table><tr><td align="center">Национальный исследовательский ядерный университет "МИФИ"</td></tr>';
        $html .= '<tr><td align="center">'.$name. ' по курсу "ДМ-3: Теория алгоритмов и сложность вычислений"</td></tr></table>';
        $this->WriteHTML($html);
    }

    /** нижний колонтитул */
    function Footer(){
        //Позиция на 1,5 cm от нижнего края страницы
        $this->SetY(-15);
        //Шрифт Arial, курсив, размер 8
        $this->SetFont('DejaVuSansMono','',8);
        //Номер страницы
        $this->Cell(0,10,'Страница '.$this->PageNo().'/{nb}',0,0,'C');
    }

    /** Информация о билете
     @variant номер варианта
     */
    function info($variant){
        $html = '<p style="text-decoration: underline;">&nbsp;&nbsp;&nbsp; Фамилия';
        $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Группа';
        $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Вариант '.$variant;
        $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y").'</p>';                                                                                  // Подчеркивание
        $this->WriteHTML($html);
    }

    /** Таблица результатов
     @amount количество вопросов в тесте
     */
    function task_table($amount){
        $this->SetFont('DejaVuSansMono','',10);
        $div_amount = intval($amount / $this::MAX_COL);
        $mod_amount = $amount % $this::MAX_COL;
        $i = 1;
        for ($j = 1; $j <= $div_amount; $j++){                                                                          // циклы полных строчек в 15 вопросов
            $this->Cell(17,10,'Вопрос',1,0);
            for ($p = 1 ; $p <= $this::MAX_COL; $p++){                                                                  //вопросы
                $this->Cell(10,10,$i,1,0);
                $i++;
            }
            $this->Ln();
            $this->Cell(17,10,'Баллы',1,0);
            for ($k = 1 ; $k <= $this::MAX_COL; $k++){                                                                  //баллы
                $this->Cell(10,10,'',1,0);
            }
            $this->Ln(12);
        }

        $this->Cell(17,10,'Вопрос',1,0);                                                                                //остаточная строка
        for ($p = 1 ; $p <= $mod_amount; $p++){                                                                         //вопросы
            $this->Cell(10,10,$i,1,0);
            $i++;
        }
        $this->Cell(15,10,'Всего',1,1);
        $this->Cell(17,10,'Баллы',1,0);
        for ($k = 1 ; $k <= $mod_amount; $k++){                                                                         //баллы
            $this->Cell(10,10,'',1,0);
        }
        $this->Cell(15,10,'',1,1);
        $this->Ln(4);
    }

    public static function translit($string){
        $translit = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'j',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'x',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'\'',
            'э' => 'e\'',   'ю' => 'yu',  'я' => 'ya',
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'J',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
            'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
            'Ь' => '\'',  'Ы' => 'Y\'',   'Ъ' => '\'\'',
            'Э' => 'E\'',   'Ю' => 'YU',  'Я' => 'YA',
        );
        $translit_string = strtr($string, $translit);
        return $translit_string;
    }

    /** должна упаковывать полученную папку в архив и отправлять пользователю, затем стирать папку и наверное оставлять архив
     * @param $dir
     * директория, в которой лежат файлы этого теста без слеша
     * @return bool возвращает true, если архив удачно создан
     */
    public static function pdfToZip($dir){
        $zip = new ZipArchive;
        $temp_zips = [];
        if ($zip -> open($dir.'.zip', ZipArchive::CREATE) === TRUE)
        {
            $temp = opendir( $dir );
            while(false !== ($d = readdir( $temp )) ){
                if ($d != '.' && $d != '..'){
                    if (!is_file($dir.'/'.$d)){
                        $temp_zip = Mypdf::pdfToZip($dir.'/'.$d);
                        $nodes = explode('/', $temp_zip);
                        $zip_name = $nodes[count($nodes) - 1];
                        $zip->addFile($temp_zip, $zip_name);
                        array_push($temp_zips, $temp_zip);
                    }
                    else
                        $zip->addFile($dir.'/'.$d, $d);
                }
            }
            $zip -> close();
            foreach ($temp_zips as $zip){
                unlink($zip);
            }
            return $dir.'.zip';
        }
        else return false;
    }
} 