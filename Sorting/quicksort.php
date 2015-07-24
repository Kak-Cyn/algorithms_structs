<?php

namespace Sorting;

require_once 'swap.php';

function partition(array &$input, $i, $k) {
    $index = $i + (($k - $i) / 2);
    $value = $input[$index];

    Arrays\swapWithTemp($input, $index, $k);

    $store = $i;

    while ($i < $k) {
        if ($input[$i] < $value) {
            Arrays\swapWithTemp($input, $i, $store);
            $store++;
        }
        $i++;
    }
    Arrays\swapWithTemp($input, $store, $k);

    return $store;
}

function _quicksort(array &$input, $lo, $hi) {
    if ($lo < $hi) {
        $pivot = partition($input, $lo, $hi);
        _quicksort($input, $lo, $pivot - 1);
        _quicksort($input, $pivot + 1, $hi);
    }
}

function quicksort(array &$input) {
    _quicksort($input, 0, count($input) - 1);
}