<?php

namespace Sorting;

require_once 'swap.php';

function bubblesort(array &$input) {
    $itr = count($input);

    if ($itr === 1) {
        return;
    }

    $n = $itr;
    $nNew = null;
    do {
        $nNew = 0;
        for ($i = 1; $i < $n; $i++) {
            if ($input[$i - 1] > $input[$i]) {
                Arrays\swapInPlace($input, $i - 1, $i);
                $nNew = $i;
            }
        }
        $n = $nNew;
    } while ($n !== 0);
}