<?php

/**
 * This example shows how to create a literal containing a string - its datatype is set to xsd:string per default.
 *
 * We use Impl-classes here (e.g. LiteralImpl), which are implementations of the according
 * interface (e.g. Literal). It is also possible that you create your own implementation.
 */

require dirname(__FILE__) .'/../vendor/autoload.php';

// create an instance of LiteralImpl by given a string
// a literal must be instanciated with a string value, and will throw an exception otherwise.
$literal = new Saft\Rdf\LiteralImpl('foo');

// output the value of the literal
echo PHP_EOL. 'literal: '. $literal->getValue();
