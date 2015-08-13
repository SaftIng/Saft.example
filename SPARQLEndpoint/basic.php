<?php

/**
 * That file is a basic runable SPARQL endpoint and can handle ASK and SELECT queries. Copy That
 * file in a folder of your webserver and voilá, and it will handles SPARQL queries coming via
 * query parameter.
 *
 *      call http://localhost/test/?query=SELECT ... to get a result
 *
 * That particular implementation provides access to a Virtuoso store, which is
 * usually not necessary due Virtuoso has its own SPARQL endpoint, but is for demonstration purposes
 * only.
 *
 * That implementation is Access-Control-Allow-Origin friendly.
 */

require 'vendor/autoload.php';

use Saft\Addition\Virtuoso\Store\Virtuoso;
use Saft\Rdf\NodeFactoryImpl;
use Saft\Rdf\StatementFactoryImpl;
use Saft\Rdf\StatementIteratorFactoryImpl;
use Saft\Sparql\Query\QueryFactoryImpl;
use Saft\Sparql\Query\QueryUtils;
use Saft\Sparql\Result\ResultFactoryImpl;

if (false == isset($_REQUEST['query']) || empty($_REQUEST['query'])) {
    echo json_encode('No query paramter given.');
    return;
}

$config = array(
    'dsn' => 'VOS',
    'username' => 'dba',
    'password' => 'dba'
);

$virtuoso = new Virtuoso(
    new NodeFactoryImpl(),
    new StatementFactoryImpl(),
    new QueryFactoryImpl(),
    new ResultFactoryImpl(),
    new StatementIteratorFactoryImpl(),
    $config
);

$queryResult = $virtuoso->query(urldecode($_REQUEST['query']));

// ask
if ('askQuery' === QueryUtils::getQueryType($_REQUEST['query'])) {
    $result = array(
        'head' => array('link' => array()), 'boolean' => $queryResult->getValue()
    );

// select
} elseif ('selectQuery' === QueryUtils::getQueryType($_REQUEST['query'])) {
    $result = array(
        'head' => array(
            'link' => array(),
            'vars' => $queryResult->getVariables()
        ),
        'results' => array(
            'distinct' => 'TODO',
            'ordered' => 'TODO',
            'bindings' => array()
        )
    );

    foreach ($queryResult as $key => $entry) {
        $resultEntry = array();

        foreach ($queryResult->getVariables() as $var) {
            // uri
            if ($entry[$var]->isNamed()) {
                $resultEntry[$var] = array(
                    'type' => 'uri',
                    'value' => $entry[$var]->getUri()
                );

            // literal
            } elseif ($entry[$var]->isLiteral()) {
                $resultEntry[$var] = array(
                    'type' => 'literal',
                    'value' => $entry[$var]->getValue()
                );
            }
        }

        $result['results']['bindings'][] = $resultEntry;
    }
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Content-Type: application/json');
echo json_encode($result);
