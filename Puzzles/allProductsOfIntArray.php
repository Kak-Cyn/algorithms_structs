<?php

namespace Puzzles;

// https://www.interviewcake.com/question/product-of-other-numbers
function allProductsOfIntArrayExceptAtIndex(array $array) {
    $products = [];
    $n = count($array);

    $product = 1;
    for ($i = 0; $i < $n; $i++) {
        $products[$i] = $product;
        $product *= $array[$i];
    }

    $product = 1;
    for ($i = $n - 1; $i >= 0; $i--) {
        $products[$i] *= $product;
        $product *= $array[$i];
    }

    return $products;
}
