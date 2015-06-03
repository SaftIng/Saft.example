<?php

/**
 * This example shows how to force a certain class as substitution of an interface.
 * The class must implement that interface.
 */

require dirname(__FILE__) .'/../../vendor/autoload.php';

$rule = new \Dice\Rule();
$rule->substitutions['Saft\Rdf\Node'] = new \Dice\Instance('Saft\Rdf\NamedNodeImpl');

$dice = new \Dice\Dice();
$dice->addRule('Saft\Rdf\NamedNodeImpl', $rule);

$namedNode = $dice->create('Saft\Rdf\NamedNodeImpl', array('http://uri'));

echo $namedNode->getUri();
