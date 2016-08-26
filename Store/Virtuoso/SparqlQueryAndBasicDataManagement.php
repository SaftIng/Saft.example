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
use Saft\Addition\Virtuoso\Store\Virtuoso;

/**
 * Configuration information about how to access Virtuoso.
 */
$config = array(
    'dsn' => 'VOS',
    'username' => 'dba',
    'password' => 'dba'
);

// instantiate the store adapter which handles the communication with Virtuoso.
$virtuoso = new Virtuoso(
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
$setIterator = $virtuoso->query('SELECT ?s FROM <http://saft/test> WHERE {?s ?p ?o}');
foreach ($setIterator as $key => $entry) {

    echo PHP_EOL . $entry['s']->getUri();

    // Saft will check the value of each binding and uses the appropriate Node type.
    // we can use getUri here, because we know that it can only be an URI, but in case
    // you dont know, you can use the following isX methods to determine the type of the
    // binding.

    if ($entry['s']->isNamed()) {
        echo PHP_EOL .'binding s is a named node.'; // e.g. NamedNodeImpl
    } elseif ($entry['s']->isLiteral()) {
        echo PHP_EOL .'binding s is a literal.'; // e.g. LiteralImpl
    } elseif ($entry['s']->isBlank()) {
        echo PHP_EOL .'binding s is a blank node.'; // e.g. BlankNodeImpl
    } elseif ($entry['s']->isPattern()) {
        echo PHP_EOL .'binding s is a pattern/placeholder/variable.'; // e.g. AnyPatternImpl
    }
}

// drop test graph
$virtuoso->dropGraph (new NamedNodeImpl('http://saft/test'));
echo PHP_EOL;
