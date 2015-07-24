<?php

namespace Sorting\Arrays;

function swapInPlace(array &$input, $i, $k) {
    $input[$i] += $input[$k];
    $input[$k] = $input[$i] - $input[$k];
    $input[$i] -= $input[$k];
}

function swapWithTemp(array &$input, $i, $k) {
    $tmp = $input[$i];
    $input[$i] = $input[$k];
    $input[$k] = $tmp;
}