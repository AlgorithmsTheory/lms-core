<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 31.07.2017
 * Time: 0:00
 */

namespace App\Testing\TestGeneration;


use App\Testing\TestStructure;

class StructuralNode extends Node {
    public $id_structure;
    public $amount;

    public function __construct($id_structure, $amount) {
        parent::__construct();
        $this->id_structure = $id_structure;
        $this->amount = $amount;
    }
}