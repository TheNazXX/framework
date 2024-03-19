<?php 

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\Kernel;
use Framework\Router\Router;

define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$kernel = new Kernel(new Router());

$response = $kernel->handle($request);

$response->send();