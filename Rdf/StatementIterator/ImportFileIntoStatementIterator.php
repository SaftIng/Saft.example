<?php

/**
 * This file shows an example how to parse a n3-file and load all of its statements
 * into a statement iterator.
 */

require __DIR__ .'/../../vendor/autoload.php';

use Saft\Addition\EasyRdf\Data\ParserEasyRdf;
use Saft\Rdf\AnyPatternImpl;
use Saft\Rdf\ArrayStatementIteratorImpl;
use Saft\Rdf\LiteralImpl;
use Saft\Rdf\NamedNodeImpl;
use Saft\Rdf\NodeFactoryImpl;
use Saft\Rdf\StatementFactoryImpl;
use Saft\Rdf\StatementImpl;

// load file content
$fileContent = file_get_contents(__DIR__ . '/demo-statements.ttl');

// init parser to parse n3 file content (using EasyRdf)
$parser = new ParserEasyRdf(
    new NodeFactoryImpl(),
    new StatementFactoryImpl(),
    'turtle' // RDF format of the file to parse later on (ttl => turtle)
);
// parse file content and transform it into a statement
$statementIterator = $parser->parseStringToIterator($fileContent);

echo PHP_EOL;

// go through all statements of the iterator and output their content
foreach ($statementIterator as $key => $statement) {
    echo '#' . $key . ' - ' .
        (string)$statement->getSubject() . ' - ' .
        (string)$statement->getPredicate() . ' - ' .
        (string)$statement->getObject() . PHP_EOL;
}
