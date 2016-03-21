<?php

/**
 * This file demonstrates the usage of ParserFactory class from Saft\Skeleton.
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Saft\Rdf\NodeFactoryImpl;
use Saft\Rdf\StatementFactoryImpl;
use Saft\Skeleton\Data\ParserFactory;

// Init the parser factory. It encapsulates different parser frameworks, e.g. from EasyRdf,
// and hide their implementation to the user. You only need this class to create an instance
// of a suitable parser class.
$parserFactory = new ParserFactory(new NodeFactoryImpl(), new StatementFactoryImpl());

/**
 * Ask for a parser-instance, which can parse a given serialization.
 *
 * Available serializations are currently:
 * - n-triples
 * - rdf-json
 * - rdf-xml
 * - rdfa
 * - turtle
 */
$parser = $parserFactory->createParserFor('rdf-xml');

if (null == $parser) {
    // FYI: if $parser is null, there is no parser available for given serialization
}

// parse a file and transform their content to a StatementIterator
$statementIterator = $parser->parseStreamToIterator(__DIR__ . '/example.xml');

// go through iterator and output the first few statements
$i = 0;
foreach ($statementIterator as $statement) {
    echo (string)$statement->getSubject()
        . ' ' . (string)$statement->getPredicate()
        . ' ' . (string)$statement->getObject()
        . PHP_EOL;

    if ($i++ == 10) { break; }
}
