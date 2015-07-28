<?php

namespace Search;

function _subsetSum(&$targetSum, &$targetSubsetSize,
                    array &$integers, array &$subsets, $size, array $subset = [],
                    $subsetSize = 0, $subsetSum = 0, $pos = 0) {
  if ($subsetSize < $targetSubsetSize) {
    $targetSizeReached = $subsetSize + 1 == $targetSubsetSize;

    for ($i = $pos; $i < $size; $i++) {
      if ($targetSizeReached && $subsetSum + $integers[$i] === $targetSum) {
        $subsets[] = array_merge($subset, [$integers[$i]]);
        #echo implode(' + ', end($subsets)) . ' = ' . array_sum(end($subsets)) . "\n";

        // don't expand beyond this point - we just hit subset size limitation
        continue;
      }

      // array needs to be sorted asc for this pruning to work
      if ($subsetSum + $integers[$i] > $targetSum) {
        // sum can't be negated and target sum exceeded - don't expand
        continue;
      }

      _subsetSum($targetSum, $targetSubsetSize,
                $integers, $subsets, $size, array_merge($subset, [$integers[$i]]),
                $subsetSize + 1, $subsetSum + $integers[$i], $i + 1);
    }
  }
}

// max recursion level should be <current call depth> + $subsetSize * 2 + 1
// i.e. 0 + call to subsetSum + ($subsetSize * 2)
function subsetSum(array &$integers, $subsetSize, $targetSum) {
  $n = count($integers);
  if ($n < $subsetSize) {
    throw new \Exception('Require at least ' . $subsetSize . ' elements');
  }

  // we sort so can do more aggressive pruning when
  // there's no upcoming negative values
  sort($integers);

  $subsets = [];
  _subsetSum($targetSum, $subsetSize, $integers, $subsets, count($integers));

  unset($integers);
  return $subsets;
}
