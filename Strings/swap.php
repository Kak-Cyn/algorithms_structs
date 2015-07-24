<?php

namespace Strings;

function swapCharacters($input, $i, $k) {
    $tmp = $input[$i];
    $input[$i] = $input[$k];
    $input[$k] = $tmp;

    return $input;
}