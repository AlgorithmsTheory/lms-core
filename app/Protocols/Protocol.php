<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 20.05.16
 * Time: 2:04
 */

namespace App\Protocols;


use App\Mypdf;
use App\Testing\Test;
use App\User;

abstract class Protocol {
    const PROTOCOL_PATH = 'archive/protocols/';
    public $test;
    public $user;
    public $filename;
    public $html;

    public function __construct($test, $user, $html){
        $this->setTest($test);
        $query = User::whereId($user)->select('first_name', 'last_name')->first();
        $this->user = $query->first_name.' '.$query->last_name;
        $this->setFilename();
        $this->html = $html;
    }

    /** Шапка протокола */
    private function header(Mypdf $pdf){
        $html = '<table style="margin: auto;"><tr><td>Национальный исследовательский ядерный университет "МИФИ"</td></tr>';
        $html .= '<tr><td style="text-align: center;">Протокол</td></tr></table>';
        $html .= '<p>ФИО студента: '.$this->user.'</p>';
        $html .= '<p>Название теста: '.$this->test.'</p>';
        $pdf->AliasNbPages();                                                                                           // для вывода общего числа страниц
        $pdf->AddPage();
        $pdf->WriteHTML($html);
    }

    abstract function setTest($id_test);
    abstract function setFilename();

    /** Создание pdf-протокола */
    public function create(){
        $pdf = new Mypdf();
        $this->header($pdf);
        $pdf->WriteHTML($this->html);
        $pdf->Output($this->filename, 'F');
    }

} 