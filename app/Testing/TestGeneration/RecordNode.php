<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:56
 */

namespace App\TestGeneration;


class RecordNode extends Node
{
    private $section_code;
    private $theme_code;
    private $type_code;

    function __construct($section, $theme, $type)
    {
        $this->section_code = $section;
        $this->theme_code = $theme;
        $this->type_code = $type;
    }

    public function getSectionCode()
    {
        return $this->section_code;
    }


    public function getThemeCode()
    {
        return $this->theme_code;
    }


    public function getTypeCode()
    {
        return $this->type_code;
    }
}