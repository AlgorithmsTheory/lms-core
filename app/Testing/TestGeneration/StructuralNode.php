<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 31.07.2017
 * Time: 0:00
 */

namespace App\TestGeneration;


use App\Testing\TestStructure;

class StructuralNode extends Node {
    private $structure;

    public function __construct(TestStructure $structure) {
        $this->structure = $structure;
    }

    public function getStructure() {
        return $this->structure;
    }
}