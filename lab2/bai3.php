<?php

class MathHelper
{
    public static function add($a, $b)
    {
        return $a + $b;
    }
}
class AdvancedMath extends MathHelper
{
    public static function pow($a, $b)
    {
        return $a ** $b;
    }
}
echo '3 + 5 = '.MathHelper::add(3, 5).'<br>';
echo '2 ^ 3 = '.AdvancedMath::pow(2, 3).'<br>';
