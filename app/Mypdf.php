<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.12.15
 * Time: 18:08
 */

namespace App;

class Mypdf extends \mPDF{
    const MAX_COL = 15;

    /** шапка певого листа
     @name название теста
     */
    function Head($name){
        $html = '<p align="center">Национальный исследовательский ядерный университет "МИФИ"</p>';
        $html .= '<p align="center">'.$name. 'по курсу "ДМ-3: Теория алгоритмов и сложность вычислений"';
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
    }



} 