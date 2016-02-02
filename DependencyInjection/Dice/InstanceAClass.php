<?php

/**
 * This example shows how to instantiate a class by calling $dice->create.
 * For more information about the basic usage of Dice, please have a look
 * here: https://r.je/dice.html#example1
 */

require dirname(__FILE__) .'/../../vendor/autoload.php';

class A {
    public $b = 'b';
}

$dice = new \Dice\Dice();
$a = $dice->create('A');

echo $a->b.PHP_EOL;
