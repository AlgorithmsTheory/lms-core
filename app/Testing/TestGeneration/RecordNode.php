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
    /**
     * @var int
     */
    public $section_code;

    /**
     * @var int
     */
    public $theme_code;

    /**
     * @var int
     */
    public $type_code;

    function __construct($section, $theme, $type) {
        parent::__construct();
        $this->section_code = $section;
        $this->theme_code = $theme;
        $this->type_code = $type;
    }

    /**
     * @param StructuralRecord $record
     * @return bool
     */
    public function equalsToRecord(StructuralRecord $record) {
        return
            $this->section_code == $record->section_code &&
            $this->theme_code == $record->theme_code &&
            $this->type_code == $record->type_code;
    }

    public function equalsForStructure(RecordNode $node) {
        return
            $this->section_code == $node->section_code &&
            $this->theme_code == $node->theme_code &&
            $this->type_code == $node->type_code;
    }

    public function toString() {
        return "{$this->section_code}/{$this->theme_code}/{$this->type_code}";
    }
}