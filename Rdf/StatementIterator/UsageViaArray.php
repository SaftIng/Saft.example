<?php

/**
 * This file shows a basic example of how to use an array-based statement iterator.
 * We first create some statements, put them into the iterator and afterwards iterate
 * over it.
 */

require __DIR__ .'/../vendor/autoload.php';

use Saft\Rdf\AnyPatternImpl;
use Saft\Rdf\ArrayStatementIteratorImpl;
use Saft\Rdf\LiteralImpl;
use Saft\Rdf\NamedNodeImpl;
use Saft\Rdf\StatementImpl;

// 2 statements stored in an array
$statements = array(
    new StatementImpl(
    new NamedNodeImpl('http://foo/s'),
    new NamedNodeImpl('http://foo/p'),
    new NamedNodeImpl('http://foo/o')
    ),
    new StatementImpl(
        new NamedNodeImpl('http://foo/s'),
        new NamedNodeImpl('http://foo/p'),
        new LiteralImpl('literal')
    )
);

// init the iterator using the array
$statementIterator = new ArrayStatementIteratorImpl($statements);

echo PHP_EOL;

// go through all statements of the iterator and output their content
foreach ($statementIterator as $key => $statement) {
    echo '#' . $key . ' - ' .
        (string)$statement->getSubject() . ' - ' .
        (string)$statement->getPredicate() . ' - ' .
        (string)$statement->getObject() . PHP_EOL;
}
