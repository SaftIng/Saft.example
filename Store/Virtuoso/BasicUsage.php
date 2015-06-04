<?php

/**
 * This example shows a very basic example of how to use Virtuoso store implementation. We will use
 * Virtuoso as a shortcut for Virtuoso Universal Server later on.
 */

require dirname(__FILE__) .'/../../vendor/autoload.php';

use Saft\Rdf\NodeFactoryImpl;
use Saft\Rdf\StatementFactoryImpl;
use Saft\Rdf\StatementIteratorFactoryImpl;
use Saft\Sparql\Query\QueryFactoryImpl;
use Saft\Store\Result\ResultFactoryImpl;

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

// output a list of all available graphs
echo 'Available graphs:'. PHP_EOL;
foreach ($virtuoso->getGraphs() as $graph) {
    echo PHP_EOL .'-'. $graph->getUri();
}

// if you dont see a graph in the output, than because there is no one, at least for the public.
// so you should take a look into the conductor and create an example graph.
