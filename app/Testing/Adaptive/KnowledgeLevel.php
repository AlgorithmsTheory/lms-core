<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 27.11.18
 * Time: 11:38
 */

namespace App\Testing\Adaptive;


class KnowledgeLevel {

    /**
     * @var int
     */
    private $level;

    /**
     * @var BolognaMark
     */
    private $bolognaMark;


    public function __construct($level, $bolognaMark) {
        $this->level = $level;
        $this->bolognaMark = $bolognaMark;
    }

    public function getLevel() {
        return $this->level;
    }

    public function getBolognaMark() {
        return $this->bolognaMark;
    }

    public static function getKnowledgeLevel($points) {
        if ($points <= 1.0 && $points >= 0.9) return new KnowledgeLevel(1, BolognaMark::A);
        if ($points < 0.9 && $points >= 0.85) return new KnowledgeLevel(2, BolognaMark::B);
        if ($points < 0.85 && $points >= 0.75) return new KnowledgeLevel(3, BolognaMark::C);
        if ($points < 0.75 && $points >= 0.7) return new KnowledgeLevel(4, BolognaMark::D1);
        if ($points < 0.7 && $points >= 0.65) return new KnowledgeLevel(5, BolognaMark::D2);
        if ($points < 0.65 && $points >= 0.6) return new KnowledgeLevel(6, BolognaMark::E);
        else return new KnowledgeLevel(7, BolognaMark::F);
    }
}