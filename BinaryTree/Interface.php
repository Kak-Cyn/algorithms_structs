<?php

namespace BinaryTree;

interface BinaryTreeInterface
{
    public function add($value);
    public function remove($value);
    public function find($value);
    public function traverse($onValueCallback, $reverse = false);
}