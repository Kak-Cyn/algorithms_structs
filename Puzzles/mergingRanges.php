<?php

namespace Puzzles;

// https://www.interviewcake.com/question/merging-ranges
function calendarAvailability(array $meetings) {
    $ranges = [];

    if (count($meetings) <= 1) {

        return $meetings;
    }

    usort($meetings, function($a, $b) {
        if ($a[0] == $b[0]) {

            return 0;
        }

        return $a[0] > $b[0] ? 1 : -1;
    });

    $j = 0;
    $ranges[$j] = $meetings[0];

    for ($i = 1, $n = count($meetings); $i < $n; $i++) {
        if ($meetings[$i][0] <= $ranges[$j][1]) {
            $ranges[$j][1] = $meetings[$i][1];
        } else {
            $j++;
            $ranges[$j] = $meetings[$i];
        }
    }

    return $ranges;
}
