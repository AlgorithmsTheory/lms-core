<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 20.05.16
 * Time: 2:56
 */
namespace App\Protocols;
//use App\Testing\Test;
class HAMProtocol extends Protocol {
    const HAM_PROTOCOL_DIR = 'nam_protocols/';
    public function setTest($id){
        //$this->test = Test::whereId_test($id_test)->select('test_name')->first()->test_name;
        $this->test =  $id;
    }
    public function setBaseDir(){
        return $this::PROTOCOL_PATH.$this::HAM_MRPROTOCOL_DIR;
    }
} 