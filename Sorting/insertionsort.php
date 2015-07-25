<?php

namespace Sorting;

function insertionSort(array &$array) {
    for ($i = 1, $n = count($array); $i < $n; $i++) {
        $j = $i;
        $v = $array[$j];

        while ($j != 0 && $array[$j - 1] > $v) {
            $array[$j] = $array[$j - 1];
            $j--;
        }
        $array[$j] = $v;
    }
}