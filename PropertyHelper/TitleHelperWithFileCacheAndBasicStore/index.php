<?php

namespace Saft\Example\PropertyHelper;

/**
 * TitleHelper with FileCache and BasicTriplePatternStore
 *
 * This file is ready to use and allows you, to insert it into your project and provide a titlehelper service out
 * of the box. Before you do that, please run 'composer update' to get all the required vendors.
 *
 * To setup a service, you can use Saft\Skeleton\PropertyHelper\RequestHandler. It encapsulates all the hassle you
 * need to do to setup the infrastructure. You just need to configure a few things and are good to go.
 *
 * If you want to use your own store, e.g. Virtuoso, just replace the $store variable and set it up. After that,
 * it should automatically use your new store instead of the BasicTriplePatternStore.
 *
 *
 * Usage:
 *   + make the index.php accessible
 *   + to build an index call index.php?action=createindex
 *   + to fetch values (e.g. titles) call index.php?action=fetchvalues&payload=http://uri/you/want/title/from
 */

use Saft\Rdf\LiteralImpl;
use Saft\Rdf\NamedNodeImpl;
use Saft\Rdf\NodeFactoryImpl;
use Saft\Rdf\StatementImpl;
use Saft\Rdf\StatementFactoryImpl;
use Saft\Rdf\StatementIteratorFactoryImpl;
use Saft\Sparql\Query\QueryFactoryImpl;
use Saft\Sparql\Query\QueryUtils;
use Saft\Sparql\Result\ResultFactoryImpl;
use Saft\Store\BasicTriplePatternStore;
use Saft\Skeleton\PropertyHelper\RequestHandler;

require 'vendor/autoload.php';

// handle action
$action = isset($_REQUEST['action']) ? strtolower($_REQUEST['action']) : '';
$payload = isset($_REQUEST['payload']) ? $_REQUEST['payload'] : '';

// pre set result - that container will be used to communicate with the client later on
$result = array('result' => 'false', 'errorMessage' => '');

try {
    // store - setup connection to a demo store, which stores everything in memory
    // just replace this instance with a Virtuoso instance for instance
    $store = new BasicTriplePatternStore(
        new NodeFactoryImpl(),
        new StatementFactoryImpl(),
        new QueryFactoryImpl(),
        new StatementIteratorFactoryImpl(),
        new ResultFactoryImpl()
    );

    // add demo statement to store, so that you can see something in the end. remove that
    // call, if you use a real store.
    $store->addStatements(array(
        new StatementImpl(
            new NamedNodeImpl('http://saft/test/s1'),
            new NamedNodeImpl('http://purl.org/dc/terms/title'),
            new LiteralImpl('s1 dcterms title')
        )
    ));

    // setup request handler - give store instance, where it gets the data from, and the graph
    $requestHandler = new RequestHandler($store, new NamedNodeImpl('http://compare/2#'));

    // setup cache using filecache
    $requestHandler->setupCache(array(
        'name' => 'file',
        'dir' => sys_get_temp_dir()
    ));

    // set titlehelper (title related properties will be used)
    $requestHandler->setType('title');

    if (false == in_array($action, array('createindex', 'fetchvalues'))) {
        throw new \Exception('Parameter action not given, empty or unknown: '. $action);
    }

    switch($action) {
        // build index for resources and according property values
        case 'createindex':
            $requestHandler->handle('createindex');
            $result['result'] = true;
            break;
        // fetch values for certain resources
        case 'fetchvalues':
            $result['result'] = $requestHandler->handle('fetchvalues', explode(',', $payload));
            break;
    }

} catch (\Exception $e) {
    $result['errorMessage'] = $e->getMessage();
}

// output result
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
// header('Content-Type: application/json');

echo json_encode($result);
