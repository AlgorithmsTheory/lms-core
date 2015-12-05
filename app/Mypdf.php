<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.12.15
 * Time: 18:08
 */

namespace App;


use Anouar\Fpdf\Fpdf;

class Mypdf extends Fpdf{
    const MAX_COL = 15;

    /** шапка певого листа
     @name название теста
     */
    function Head($name){
        //Логотип
        //шрифт Arial, жирный, размер 15
        $this->SetFont('TimesNewRomanPSMT','',10);
        //Перемещаемся вправо
        $this->Cell(80);
        //Название
        $this->Cell(30,5, iconv('utf-8', 'windows-1251', 'Национальный исследовательский ядерный университет "МИФИ"'),0,0,'C');
        $this->Ln();
        $this->Cell(80);
        $this->Cell(30,5, iconv('utf-8', 'windows-1251', $name.' по курсу "ДМ-3: Теория алгоритмов и сложность вычислений"'),0,1,'C');
    }

    /** нижний колонтитул */
    function Footer(){
        //Позиция на 1,5 cm от нижнего края страницы
        $this->SetY(-15);
        //Шрифт Arial, курсив, размер 8
        $this->SetFont('TimesNewRomanPSMT','',8);
        //Номер страницы
        $this->Cell(0,10,iconv('utf-8', 'windows-1251', 'Страница '.$this->PageNo().'/{nb}'),0,0,'C');
    }

    /** Информация о билете
     @variant номер варианта
     */
    function info($variant){
        $this->Cell(5);
        $this->Cell(80,10,iconv('utf-8', 'windows-1251', 'Фамилия'));                                                   // Фамилия
        $this->Cell(50,10,iconv('utf-8', 'windows-1251', 'Группа'));                                                    // Группа
        $this->Cell(40,10,iconv('utf-8', 'windows-1251', 'Вариант '.$variant));                                         // Номер варианта
        $this->Cell(3,10,iconv('utf-8', 'windows-1251', date("Y")),0,1);                                                // Год
        $this->Line(10,28,200,28);                                                                                      // Подчеркивание
    }

    /** Таблица результатов
     @amount количество вопросов в тесте
     */
    function task_table($amount){
        $div_amount = intval($amount / $this::MAX_COL);
        $mod_amount = $amount % $this::MAX_COL;
        $i = 1;
        for ($j = 1; $j <= $div_amount; $j++){                                                                          // циклы полных строчек в 15 вопросов
            $this->Cell(17,10,iconv('utf-8', 'windows-1251', 'Вопрос'),1,0);
            for ($p = 1 ; $p <= $this::MAX_COL; $p++){                                                                        //вопросы
                $this->Cell(10,10,iconv('utf-8', 'windows-1251', $i),1,0);
                $i++;
            }
            $this->Ln();
            $this->Cell(17,10,iconv('utf-8', 'windows-1251', 'Баллы'),1,0);
            for ($k = 1 ; $k <= $this::MAX_COL; $k++){                                                                        //баллы
                $this->Cell(10,10,iconv('utf-8', 'windows-1251', ''),1,0);
            }
            $this->Ln(12);
        }

        $this->Cell(17,10,iconv('utf-8', 'windows-1251', 'Вопрос'),1,0);                                                //остаточная строка
        for ($p = 1 ; $p <= $mod_amount; $p++){                                                                         //вопросы
            $this->Cell(10,10,iconv('utf-8', 'windows-1251', $i),1,0);
            $i++;
        }
        $this->Cell(15,10,iconv('utf-8', 'windows-1251', 'Всего'),1,1);
        $this->Cell(17,10,iconv('utf-8', 'windows-1251', 'Баллы'),1,0);
        for ($k = 1 ; $k <= $mod_amount; $k++){                                                                         //баллы
            $this->Cell(10,10,iconv('utf-8', 'windows-1251', ''),1,0);
        }
        $this->Cell(15,10,iconv('utf-8', 'windows-1251', ''),1,1);
    }
} 