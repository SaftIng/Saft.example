<?php
namespace SaftExample;

require("vendor/autoload.php");

use Saft\Store\Store;
use Saft\Rdf\NodeFactory;
use Saft\Rdf\StatementFactory;
use Saft\Sparql\Query\QueryFactory;
use Saft\Sparql\Result\ResultFactory;

$rule = new \Dice\Rule();
$rule->substitutions['Saft\\Rdf\\NodeFactory'] = new \Dice\Instance('Saft\\Rdf\\NodeFactoryImpl');
$rule->substitutions['Saft\\Rdf\\StatementFactory'] = new \Dice\Instance('Saft\\Rdf\\StatementFactoryImpl');
$rule->substitutions['Saft\\Sparql\\Query\\QueryFactory'] = new \Dice\Instance('Saft\\Sparql\\Query\\QueryFactoryImpl');
$rule->substitutions['Saft\\Store\\Result\\ResultFactory'] = new \Dice\Instance('Saft\\Store\\Result\\ResultFactoryImpl');

$dice = new \Dice\Dice();
$dice->addRule('*', $rule);

$params = [['dsn' => 'vos', 'username' => 'dba', 'password' => 'dba']];
$store = $dice->create("Saft\\Backend\\Virtuoso\\Store\\Virtuoso", $params);

//$parser = getParser("turtle");
//$statements = $parser->parseStreamToIterator($fileStream, "http://example.org", "turtle");

class ExampleApplication
{
    private $store;
    private $nf;
    private $sf;

    public function __construct(Store $store, NodeFactory $nf, StatementFactory $sf)
    {
        $this->store = $store;
        $this->nf = $nf;
        $this->sf = $sf;
    }

    public function run()
    {
        $graph = $this->nf->createNamedNode("http://example.org/");
        $s = $this->nf->createNamedNode("http://example.org/s");
        $p = $this->nf->createNamedNode("http://example.org/p");
        $o = $this->nf->createNamedNode("http://example.org/x");
        $any = $this->nf->createAnyPattern();

        $statement = $this->sf->createStatement($s, $p, $o, $graph);
        $this->store->addStatements([$statement]);

        // Fetch Data
        $pattern = $this->sf->createStatement($s, $p, $any, $graph);
        $statements = $this->store->getMatchingStatements($pattern);

        foreach ($statements as $select) {
            var_dump($select);
        }

        // Edit Data
        //$this->store->deleteMatchingStatements(…);
        //$this->store->addStatements(…);
    }
}


$app = $dice->create('\\SaftExample\\ExampleApplication', [$store]);
$app->run();
