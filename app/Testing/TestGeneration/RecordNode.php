<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:56
 */

namespace App\Testing\TestGeneration;


use App\Testing\StructuralRecord;

class RecordNode extends Node {
    public $section_code;
    public $theme_code;
    public $type_code;

    function __construct($section, $theme, $type) {
        parent::__construct();
        $this->section_code = $section;
        $this->theme_code = $theme;
        $this->type_code = $type;
    }

    public function equalsToRecord(StructuralRecord $record) {
        return
            $this->section_code == $record->section_code &&
            $this->theme_code == $record->theme_code &&
            $this->type_code == $record->type_code;
    }
}