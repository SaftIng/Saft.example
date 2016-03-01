<?php

require dirname(__FILE__) .'/../../vendor/autoload.php';

// For more information look here: https://github.com/Level-2/Dice

// sets up a rule to tell Dice that everytime you want an instance of Literal, you want an instance
// of LiteralImpl instead, because Literal itself is an interface.
// furthermore, you define the second parameter of the constructor here.
$ruleLiteral = array(
    'instanceOf' => 'Saft\Rdf\LiteralImpl',
    'constructParams' => array(
        // define second parameter which is of type NamedNode
        new \Saft\Rdf\NamedNodeImpl('http://www.w3.org/2001/XMLSchema#string')
    )
);

// sets up a rule to tell Dice that everytime you want an instance of NamedNode, you want an instance
// of NamedNodeImpl instead, because NamedNode itself is an interface.
$ruleNamedNode = array(
    'instanceOf' => 'Saft\Rdf\NamedNodeImpl'
);

// the rules above are worthless alone, but now we connect them to certain classes.
// if you create one of these classes using this $dice instance, the rules above will
// take effect
$dice = new \Dice\Dice();
$dice->addRule('Saft\Rdf\Literal', $ruleLiteral);
$dice->addRule('Saft\Rdf\NamedNode', $ruleNamedNode);

$literal = $dice->create('Saft\Rdf\Literal', array('foo'));

echo $literal->getValue() . PHP_EOL;
