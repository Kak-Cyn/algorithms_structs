<?php

namespace BinaryTree;

class BTLNode
{
    public $value;
    public $left;
    public $right;

    public function __construct($value) {
        $this->value = $value;
    }
}

class BTLinked
{
    private $_pivot;

    public function add($value)
    {
        if (is_null($this->_pivot)) {
            $newNode = new BTLNode($value);
            $this->_pivot = &$newNode;
        } else {
            $this->_add($value, $this->_pivot);
        }
    }

    public function remove($value)
    {
        if (is_null($this->_pivot)) {
            trigger_error("Empty tree", E_USER_NOTICE);

            return null;
        }

        $nodeInfo = $this->_find($value, $this->_pivot);
        if (is_null($nodeInfo[0])) {
            trigger_error("Value ${value} not found in tree", E_USER_NOTICE);
        } else {
            $this->_removeNode($nodeInfo[0], $nodeInfo[1]);
        }
    }

    public function find($value)
    {
        if (is_null($this->_pivot)) {

            return null;
        }

        list($node, ) = $this->_find($value, $this->_pivot);
        if (!is_null($node)) {

            return $node->value;
        }

        return null;
    }

    public function traverse($onValueCallback, $reverse = false)
    {
        if (!is_null($this->_pivot)) {
            $this->_traverse($onValueCallback, $this->_pivot, $reverse);
        }
    }

    private function _add(&$value, BTLNode &$root)
    {
        $node = &$root;
        for (;;) {
            if ($node->value >= $value) {
                if (is_null($node->left)) {
                    $newNode = new BTLNode($value);
                    $node->left = &$newNode;
                    break;
                }

                $node = &$node->left;
            } else {
                if (is_null($node->right)) {
                    $newNode = new BTLNode($value);
                    $node->right = &$newNode;
                    break;
                }

                $node = &$node->right;
            }
        }

        unset($node);
    }

    private function &_find(&$value, BTLNode &$root)
    {
        $nodeInfo = [null, null];

        if ($root->value == $value) {
            $nodeInfo[0] = &$root;
        } else {
            $branch = $root->value >= $value ? 'left' : 'right';

            if (!is_null($root->{$branch})) {
                $nodeInfo = $this->_find($value, $root->{$branch});

                // we have a node, but no parent bubbled back up, thus next node was our target
                if (!is_null($nodeInfo[0]) && is_null($nodeInfo[1])) {
                    $nodeInfo[1] = &$root;
                } // else we either have a node + parent, or nothing at all
            }
        }

        return $nodeInfo;
    }

    private function _traverse(&$onValueCallback, BTLNode &$node, $reverse = false)
    {
        if ($reverse) {
            $first = 'right';
            $second = 'left';
        } else {
            $first = 'left';
            $second = 'right';
        }

        if (!is_null($node->{$first})) {
            $this->_traverse($onValueCallback, $node->{$first}, $reverse);
        }

        $onValueCallback($node->value);

        if (!is_null($node->{$second})) {
            $this->_traverse($onValueCallback, $node->{$second}, $reverse);
        }
    }

    private function _removeNode(BTLNode &$node, BTLNode &$parent)
    {
        $hasLeft = !is_null($node->left);
        $hasRight = !is_null($node->right);

        if ($hasLeft && $hasRight) {
            // two children - go right one, find min, dupe value, remove duped node

            $origNode = &$node;

            $parent = &$node;
            $node = &$node->right;

            while (!is_null($node->left)) {

                $parent = &$node;
                $node = &$node->right;
            }

            $val = $node->value;
            $this->_removeNode($node, $parent);
            $origNode->value = $val;
        } else {
            // either 1 child or leaf node
            $parentsBranch = $parent->value >= $node->value ? 'left' : 'right';

            if ($hasLeft) {
                // one child on the left
                $parent->{$parentsBranch} = &$node->left;
                $node = null;
            } else if ($hasRight) {
                // on child on the right
                $parent->{$parentsBranch} = &$node->right;
                $node = null;
            } else {
                // leaf node
                $parent->{$parentsBranch} = null;
            }
        }
    }
}