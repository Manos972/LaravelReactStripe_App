<?php

function isPalindrome(int $x): int
{
    $str = strval($x);
    return $str == strrev($str) ? 1 : 0;
}
