<?php

/**
 * This example shows how to create a named node.
 *
 * We use Impl-classes here (e.g. NamedNodeImpl), which are implementations of the according
 * interface (e.g. NamedNode). It is also possible that you create your own implementation.
 */

require dirname(__FILE__) .'/../vendor/autoload.php';

// create the named node instance by given an URI as string
// if the given string is not an URI, an exception will be thrown
$namedNode = new Saft\Rdf\NamedNodeImpl('foo:bar/1');

// output the value of the named node
echo PHP_EOL. 'named node: '. $namedNode->getUri().PHP_EOL;
