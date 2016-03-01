<?php

require dirname(__FILE__) .'/../../vendor/autoload.php';

// this tells Dice only, that an associated class has to be instantiate using the
// following constructor parameter (see addRule at the bottom for more info)
$ruleNamedNode = new \Dice\Rule();
$ruleNamedNode->constructParams = array('http://www.w3.org/1999/02/22-rdf-syntax-ns#langString');

// this tells Dice, that an associated class has to be instantiate using the
// following constructor parameter AND that each occurrences of Node
// have to be replaced with an instance of Saft\Rdf\NamedNodeImpl
$ruleLiteral = new \Dice\Rule();
$ruleLiteral->constructParams = array('literal value', 'de_DE');
$ruleLiteral->substitutions['Saft\Rdf\Node'] = new \Dice\Instance('Saft\Rdf\NamedNodeImpl');

// the rules above are worthless alone, but now we connect them to certain classes.
// if you create one of these classes using this $dice instance, the rules above will
// take effect
$dice = new \Dice\Dice();
$dice->addRule('Saft\Rdf\NamedNodeImpl', $ruleNamedNode);
$dice->addRule('Saft\Rdf\LiteralImpl', $ruleLiteral);

$literal = $dice->create('Saft\Rdf\LiteralImpl');

echo $literal->getValue().PHP_EOL;
