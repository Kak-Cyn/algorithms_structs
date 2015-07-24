<?php

namespace BinaryTree;

require_once 'Interface.php';

class BTArray implements BinaryTreeInterface
{
    protected $_tree;
    protected $_size;

    const ROOT_INDEX = 0;

    public function __construct($maxKeys = null)
    {
        if (!is_null($maxKeys)) {
            $this->_size = pow(2, $maxKeys); // worst case everything goes on a single branch. Balancing it would reduce this size requirement
            $this->_tree = new \SplFixedArray($this->_size);
        } else {
            // here's it'd still be 2 ^ n, but php arrays are actually ordered hashtables
            $this->_size = null;
            $this->_tree = [];
        }
    }

    public function add($value)
    {
        $this->_add($value);
    }

    public function remove($value)
    {
        $index = $this->_find($value);
        if (is_null($index)) {
            trigger_error("Value ${value} not found in tree", E_USER_NOTICE);
        } else {
            $this->_removeIndex($index);
        }
    }

    public function find($value)
    {
        return $this->_find($value);
    }

    public function traverse($onValueCallback, $reverse = false)
    {
        $this->_traverse($onValueCallback, $reverse);
    }

    protected function _getNextIndicies($index)
    {
        $left = $right = null;

        if (self::ROOT_INDEX === 0) {
            $left = (($index + 1) * 2) - 1;
            $right = ($index + 1) * 2;
        } else {
            $left = $index * 2;
            $right = ($index * 2) + 1;
        }

        return [$left, $right];
    }

    protected function _isNodeSet($index)
    {
        if (is_null($this->_size)) {

            return isset($this->_tree[$index]) && !is_null($this->_tree[$index]);
        }

        return $index <= $this->_size && !is_null($this->_tree[$index]);
    }

    private function _add(&$value, $index = self::ROOT_INDEX)
    {
        if ($index < self::ROOT_INDEX) {
            // SplFixedArray will throw a RuntimeException for OOB for us already
            throw new \RuntimeException('Index out of bounds');
        }

        if (!$this->_isNodeSet($index)) {
            $this->_tree[$index] = $value;
        } else {
            list($left, $right) = $this->_getNextIndicies($index);

            if ($value < $this->_tree[$index]) {
                $this->_add($value, $left);
            } else {
                $this->_add($value, $right);
            }
        }

        unset($value);
    }

    private function _traverse(&$onValueCallback, $reverse = false, $index = self::ROOT_INDEX)
    {
        list($left, $right) = $this->_getNextIndicies($index);

        if ($reverse) {
            $left += $right;
            $right = $left - $right;
            $left -= $right;
        }

        if ($this->_isNodeSet($left)) {
            $this->_traverse($onValueCallback, $reverse, $left);
        }

        $onValueCallback($this->_tree[$index]);

        if ($this->_isNodeSet($right)) {
            $this->_traverse($onValueCallback, $reverse, $right);
        }
    }

    private function _find(&$value, $index = self::ROOT_INDEX)
    {
        if ($this->_tree[$index] === $value) {

            return $index;
        }

        list($left, $right) = $this->_getNextIndicies($index);
        $next = $value < $this->_tree[$index] ? $left : $right;

        if ($this->_isNodeSet($next)) {

            return $this->_find($value, $next);
        }

        return null;
    }

    private function _removeIndex($index)
    {
        if (!$this->_isNodeSet($index)) {

            return;
        }

        list($left, $right) = $this->_getNextIndicies($index);

        if ($this->_isNodeSet($right)) {
            // alternatively go right 1, track all way left, set index to that value, take care of that node
            $this->_tree[$index] = $this->_tree[$right];
            $this->_removeIndex($right);
        } elseif ($this->_isNodeSet($left)) {
            // shift everything up
            $this->_tree[$index] = $this->_tree[$left];
            $this->_removeIndex($left);
        } else {
            // leaf node
            $this->_tree[$index] = null;

            return;
        }


    }
}