<?php

/**
 * This example shows how to create a literal with a string value and a language. In the current
 * RDF standard it is not possible to set a datatype and language freely together. It is basically
 * either a datatype or language. If you use a language, you must set the datatype to a certain URI.
 *
 * We use Impl-classes here (e.g. LiteralImpl), which are implementations of the according
 * interface (e.g. Literal). It is also possible that you create your own implementation.
 */

require dirname(__FILE__) .'/../vendor/autoload.php';

$stringLiteral = new Saft\Rdf\LiteralImpl(
    // literal value
    'foo',

    // the datatype must be a specific URI and be given as an instance of NamedNode
    new Saft\Rdf\NamedNodeImpl('http://www.w3.org/1999/02/22-rdf-syntax-ns#langString'),

    // language tag
    'en_GB'
);

echo PHP_EOL . 'stringLiteral value: '. $stringLiteral->getValue();
echo PHP_EOL . 'stringLiteral datatype: '. $stringLiteral->getDatatype();
echo PHP_EOL . 'stringLiteral lang: '. $stringLiteral->getLanguage().PHP_EOL;
