<?php

namespace Puzzles;

// https://www.interviewcake.com/question/rectangular-love

class Rectangle {
    public $x;
    public $y;
    public $width;
    public $height;

    public function __construct($x, $y, $w, $h) {
        $this->x = $x;
        $this->y = $y;
        $this->width = $w;
        $this->height = $h;
    }
}

function rectangleIntersection(Rectangle $r1, Rectangle $r2) {
    $r1TopRight_x = ($r1->x + $r1->width);
    $r1TopRight_y = ($r1->y + $r1->height);

    $r2TopRight_x = ($r2->x + $r2->width);
    $r2TopRight_y = ($r2->y + $r2->height);

    if ($r2->x >= $r1TopRight_x || $r2->y >= $r1TopRight_y || $r1->x >= $r2TopRight_x || $r1->y >= $r2TopRight_y) {

        return null; // no overlap in positive axis
    }

    $x = max($r1->x, $r2->x);
    $y = max($r1->y, $r2->y);

    $w = min($r1TopRight_x, $r2TopRight_x) - $x;
    $h = min($r1TopRight_y, $r2TopRight_y) - $y;

    return new Rectangle($x, $y, $w, $h);
};
