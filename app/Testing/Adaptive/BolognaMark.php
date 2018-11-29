<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 27.11.18
 * Time: 11:41
 */

namespace App\Testing\Adaptive;


abstract class BolognaMark {
    const A = 'A';
    const B = 'B';
    const C = 'C';
    const D1 = 'D1';
    const D2 = 'D2';
    const E = 'E';
    const F = 'F';

    public static function getBolognaMarkFromPoints($points) {
        if ($points <= 1.0 && $points >= 0.9) return BolognaMark::A;
        if ($points < 0.9 && $points >= 0.85) return BolognaMark::B;
        if ($points < 0.85 && $points >= 0.75) return BolognaMark::C;
        if ($points < 0.75 && $points >= 0.7) return BolognaMark::D1;
        if ($points < 0.7 && $points >= 0.65) return BolognaMark::D2;
        if ($points < 0.65 && $points >= 0.6) return BolognaMark::E;
        else return BolognaMark::F;
    }
}