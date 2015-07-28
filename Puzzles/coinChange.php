<?php

namespace Puzzles;

function coinChangeCombinations(array $demominations, $amount) {
    $combos = array_fill(0, $amount + 1, 0);
    $combos[0] = 1;

    foreach ($demominations as $coin) {
        for ($i = $coin; $i < $amount + 1; $i++) {
            $combos[$i] += $combos[$i - $coin];

            //echo implode(' ', array_slice($combos, 1)) . "\n";
        }
    }

    return $combos[$amount];
}

$count = coinChangeCombinations([1, 2, 5, 10, 20, 50, 100, 200, 500], 500);
echo $count . "\n";