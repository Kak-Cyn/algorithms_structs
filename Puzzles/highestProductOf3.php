<?php

namespace Puzzles;

// https://www.interviewcake.com/question/highest-product-of-3
function highestProductOf3(array $array) {
    $n = count($array);

    if ($n < 3) {
        throw new \Exception('Need at least 3 integers');
    }

    $max = max($array[0], $array[1]);
    $min = min($array[0], $array[1]);

    $highest2 = $lowest2 = $min * $max;
    $highest3 = $lowest2 * $array[2];

    for ($i = 2; $i < $n; $i++) {
        $highest3 = max($highest2 * $array[$i], $lowest2 * $array[$i], $highest3);

        $highest2 = max($min * $array[$i], $max * $array[$i], $highest2);
        $lowest2 = min($min * $array[$i], $max * $array[$i], $lowest2);

        $max = max($max, $array[$i]);
        $min = min($min, $array[$i]);
    }

    return $highest3;
}