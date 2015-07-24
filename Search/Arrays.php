<?php

namespace Search\Arrays;

function linear(&$array, $value) {
    $index = null;

    for ($i = 0, $n = count($array); $i < $n; $i++) {
        if ($array[$i] === $value) {
            $index = $i;
            break;
        }
    }

    return $index;
}

// assumes array is already sorted
function binary(&$array, $value) {
    $lo = 0;
    $hi = count($array) - 1;
    $mid = null;

    $index = null;

    while ($lo <= $hi) {
        $mid = $lo + floor(($hi - $lo) / 2);

        if ($value > $array[$mid]) {
            $lo = $mid + 1;
        } else if ($value < $array[$mid]) {
            $hi = $mid - 1;
        } else {
            $index = $mid;
            break;
        }
    }

    return $index;
}