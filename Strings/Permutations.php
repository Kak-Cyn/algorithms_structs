<?php

namespace Strings\Permutations;

require_once 'swap.php';

function permuteRecursive($str, $i, $l) {
    $count = 0;
    if ($i == $l) {
        $count++;
        echo $str . "\n";
    } else {
        for ($x = $i; $x < $l; $x++) {
            $count += permuteRecursive(\Strings\swapCharacters($str, $i, $x), $i + 1, $l);
        }
    }

    return $count;
}