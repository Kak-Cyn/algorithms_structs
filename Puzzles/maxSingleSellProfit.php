<?php

namespace Puzzles;

// https://www.interviewcake.com/question/stock-price
function maxSingleSellProfit(array &$prices) {
    if (count($prices) < 2) {

        throw new \Exception('Can\'t buy and sell');
    }

    $min = $prices[0];
    $max = $prices[1] - $prices[0];

    for ($i = 1, $n = count($prices); $i < $n; $i++) {
        $profit = $prices[$i] - $min;

        $max = max($max, $profit);
        $min = min($min, $prices[$i]);
    }

    return $max;
}