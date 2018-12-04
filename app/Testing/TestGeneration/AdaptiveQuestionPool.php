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

    public function setMainPhasePool($main_phase_pool) {
        $this->main_phase_pool = $main_phase_pool;
    }

    public function setCommonPool($common_pool) {
        $this->common_pool = $common_pool;
    }





}