<?php

namespace Sorting;

function countingSort(array &$array, $k = null) {
    $sorted = $array;

    if (is_null($k)) {
        $k = max($array);
    }

    $counts = array_fill(0, $k + 1, 0);

    $n = count($array);
    for ($i = 0; $i < $n; $i++) {
        $counts[$array[$i]]++;
    }

    for ($i = 1; $i <= $k; $i++) {
        $counts[$i] += $counts[$i - 1];
    }

    foreach ($array as $v) {
        $sorted[$counts[$v] - 1] = $v;
        $counts[$v]--;
    }

    return $sorted;
}