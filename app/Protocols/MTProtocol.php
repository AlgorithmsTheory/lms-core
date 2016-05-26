<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 20.05.16
 * Time: 2:56
 */
namespace App\Protocols;


class MTProtocol extends Protocol {
    const MT_PROTOCOL_DIR = 'tur_protocols/';
    public function setTest($id){
        //$this->test = Test::whereId_test($id_test)->select('test_name')->first()->test_name;
        $this->test = $id;
    }
    public function setBaseDir(){
        return $this::PROTOCOL_PATH.$this::MT_PROTOCOL_DIR;
    }
} 