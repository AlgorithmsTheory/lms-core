<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 20.05.16
 * Time: 2:56
 */

namespace App\Protocols;


use App\Mypdf;
use App\Testing\Test;

class TestProtocol extends Protocol {
    const TEST_PROTOCOL_DIR = 'test_protocols/';

    public function setTest($id_test){
        $this->test = Test::whereId_test($id_test)->select('test_name')->first()->test_name;
    }

    public function setFilename(){
        $now =  date("Y-m-d H-i-s");
        $file = Mypdf::translit($this->test).' '.Mypdf::translit($this->user).' '.$now.'.pdf';
        $this->filename = $this::PROTOCOL_PATH.$this::TEST_PROTOCOL_DIR.$file;
    }
} 