<?php

namespace Strings;

class Palindrome
{
    const METHOD_PIVOT = 0;
    const METHOD_NAIVE = 1;
    const METHOD_PROGRESSIVE = 2;

    static public function reverseString($string) {
        $reversed = '';

        for ($i = strlen($string) -1 ; $i >= 0; $i--) {
            $reversed .= $string[$i];
        }

        return $reversed;
    }

    static public function stripNonChars($string) {

        return preg_replace('/[^\w]+/', '', $string);
    }

    static public function isPalindromePivoted($string) {
        $string = self::stripNonChars($string);

        $len = strlen($string);
        $pivot = floor($len / 2);
        $left = substr($string, 0, $pivot);
        $right = substr($string, -$pivot); // odd length strings should have pivot char removed now

        $right = self::reverseString($right);

        return $left === $right;
    }

    static public function isPalindromeNaive($string) {
        $string = self::stripNonChars($string);

        return $string === self::reverseString($string);
    }

    static public function isPalindromeProgressive($string) {
        $string = self::stripNonChars($string);

        $len = strlen($string);
        for ($i = 0, $n = floor($len / 2); $i < $n; $i++) {
            if ($string[$i] !== $string[$len - $i - 1]) {

                return false;
            }
        }

        return true;
    }

    // and other ways too

    static public function isPalindrome($string, $method = self::METHOD_PROGRESSIVE) {
        switch ($method) {
            case self::METHOD_PIVOT:
                return self::isPalindromePivoted($string);

            case self::METHOD_NAIVE:
                return self::isPalindromeNaive($string);

            case self::METHOD_PROGRESSIVE:
            default:
                return self::isPalindromeProgressive($string);
        }
    }
}