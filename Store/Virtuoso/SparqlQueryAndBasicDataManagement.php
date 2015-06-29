<?php

/**
 * This example shows a very basic example of how to use Virtuoso store implementation. We will use
 * Virtuoso as a shortcut for Virtuoso Universal Server later on.
 */

require dirname(__FILE__) .'/../../vendor/autoload.php';

use Saft\Rdf\NamedNodeImpl;
use Saft\Rdf\NodeFactoryImpl;
use Saft\Rdf\StatementFactoryImpl;
use Saft\Rdf\StatementImpl;
use Saft\Rdf\StatementIteratorFactoryImpl;
use Saft\Sparql\Query\QueryFactoryImpl;
use Saft\Sparql\Result\ResultFactoryImpl;

/**
 * Configuration information about how to access Virtuoso.
 */
$config = array(
    'dsn' => 'VOS',
    'username' => 'dba',
    'password' => 'dba'
);

// instantiate the store adapter which handles the communication with Virtuoso.
$virtuoso = new Saft\Addition\Virtuoso\Store\Virtuoso(
    new NodeFactoryImpl(),
    new StatementFactoryImpl(),
    new QueryFactoryImpl(),
    new ResultFactoryImpl(),
    new StatementIteratorFactoryImpl(),
    $config
);

// create test graph
$virtuoso->createGraph (new NamedNodeImpl('http://saft/test'));

// add simple triple to that new graph
$virtuoso->addStatements(
    array(
        new StatementImpl(
            new NamedNodeImpl('http://saft/test'),
            new NamedNodeImpl('http://saft/test'),
            new NamedNodeImpl('http://saft/test')
        )
    ),
    new NamedNodeImpl('http://saft/test')
);

// ask graph forall its triples and print them out
$statementIterator = $virtuoso->query('SELECT ?s FROM <http://saft/test> WHERE {?s ?p ?o}');
foreach ($statementIterator as $key => $statement) {
    echo (string) $statement;
}

// drop test graph
$virtuoso->dropGraph (new NamedNodeImpl('http://saft/test'));
