<?php

use core as c;

require_once __DIR__.'/core/Loader.php';


c\Loader::start();

$request = new c\Request();
c\Router::start($request);


