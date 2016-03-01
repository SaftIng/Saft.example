<?php

/**
 * That example is meant to be executed in the terminal. It simulates a createindex call to the title
 * helper service.
 */

/*
 * Create index with resources and their titles.
 */
$_REQUEST['action'] = 'createindex';
require 'index.php';

echo PHP_EOL;

/*
 * Fetch titles from index for a given set of resources.
 */
$_REQUEST['action'] = 'fetchvalues';
$_REQUEST['payload'] = 'http://saft/test/s1';
require 'index.php';
