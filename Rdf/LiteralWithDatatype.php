<?php

/**
 * This example shows how to create a literal with a string value and a datatype set to xsd:string explicitly.
 *
 * We use Impl-classes here (e.g. LiteralImpl), which are implementations of the according
 * interface (e.g. Literal). It is also possible that you create your own implementation.
 */

require dirname(__FILE__) .'/../vendor/autoload.php';

$stringLiteral = new Saft\Rdf\LiteralImpl(
    // literal value
    'foo',
    // the datatype must be an URI and be given as an instance of NamedNode.
    new Saft\Rdf\NamedNodeImpl('http://www.w3.org/2001/XMLSchema#string')
);

echo PHP_EOL . 'stringLiteral value: '. $stringLiteral->getValue();
echo PHP_EOL . 'stringLiteral datatype: '. $stringLiteral->getDatatype();
