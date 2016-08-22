<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 20.05.16
 * Time: 2:56
 */
namespace App\Protocols;

class RecProtocol extends Protocol {
    const Rec_PROTOCOL_DIR = 'rec_protocols/';
    public function setTest($id){
        $this->test = $id;
    }

    public function setBaseDir(){
        return $this::PROTOCOL_PATH.$this::Rec_PROTOCOL_DIR;
    }
}
