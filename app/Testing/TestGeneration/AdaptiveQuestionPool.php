<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 29.11.18
 * Time: 10:51
 */

namespace App\Testing\TestGeneration;


use App\Testing\Adaptive\AdaptiveQuestion;

class AdaptiveQuestionPool {

    /**
     * @var AdaptiveQuestion[]
     */
    private $main_phase_pool = [];

    /**
     * @var AdaptiveQuestion[]
     */
    private $common_pool = [];

}