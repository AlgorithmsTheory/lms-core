<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 29.11.18
 * Time: 12:08
 */

namespace App\Testing\Adaptive;


abstract class Weights {
    const MARK_EXPECTED_BY_STUDENT_FACTOR = 0.4;
    const MARK_EXPECTED_BY_SYSTEM_FACTOR = 0.6;
    const MAX_TRAIN_TEST_INTERVAL_LENGTH = 0.05;
}