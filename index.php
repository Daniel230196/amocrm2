<?php

use core as c;

require_once 'vendor/autoload.php';

/*c\Loader::start();*/

$request = new c\Request();

c\Router::start($request);

$test = new c\RequestHelper(
    new \entities\LeadsMaker(),
    new \entities\CompaniesMaker(),
    new \entities\ContactsMaker(),
    3
);
