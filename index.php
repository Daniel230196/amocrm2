<?php

use core as c;

require_once 'vendor/autoload.php';

$request = new c\Request();

c\Router::start($request);

