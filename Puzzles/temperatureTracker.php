<?php

namespace Puzzles;

// https://www.interviewcake.com/question/temperature-tracker

class TempTracker {
    protected $_temps = [];
    private $_counts = [];
    private $_sum;
    private $_stale = false;

    public function insert($temp) {
        if (is_array($temp)) {
            array_walk($temp, [&$this, 'insert']);

            return;
        }

        $this->_stale = $temp > $this->getMax() || $temp < $this->getMin();
        $this->_temps[] = $temp;

        if (!isset($this->_counts[$temp])) {
            $this->_counts[$temp] = 1;
        } else {
            $this->_counts[$temp]++;
        }

        $this->_sum += $temp;
    }

    public function getMax() {
        if ($this->_stale) {
            $this->_countingSort();
        }

        return end($this->_temps);
    }

    public function getMin() {
        if ($this->_stale) {
            $this->_countingSort();
        }

        return $this->_temps[0];
    }

    public function getMean() {

        return $this->_sum / count($this->_temps);
    }

    public function getMode() {
        reset($this->_counts);

        $temp = key($this->_counts);
        $max = current($this->_counts);

        foreach ($this->_counts as $t => $c) {
            if ($c > $max) {
                $max = $c;
                $temp = $t;
            }
        }

        return $temp;
    }

    private function _countingSort() {
        $temps = $this->_temps;
        $counts = $this->_counts;

        $sum = 0;
        foreach ($counts as $t => $c) {
            $counts[$t] = $sum;
            $sum += $c;
        }

        for ($i = 0, $n = count($this->_temps); $i < $n; $i++) {
            $temps[$counts[$this->_temps[$i]]] = $this->_temps[$i];
            $counts[$this->_temps[$i]]++;
        }

        $this->_temps = $temps;
        $this->_stale = false;
    }
}

$tracker = new TempTracker();
$tracker->insert([97, 98, 98, 99]);
echo 'Max:  ' . $tracker->getMax() . "\n";
echo 'Min:  ' . $tracker->getMin() . "\n";
echo 'Mean: ' . $tracker->getMean() . "\n";
echo 'Mode: ' . $tracker->getMode() . "\n";