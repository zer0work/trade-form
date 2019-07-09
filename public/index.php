<?php
error_reporting(E_ALL);
require_once __DIR__ . '/../app/autoload.php';


$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $uri);
$parts[2] =  @explode('?', $parts[2])[0];

$controllerName = $parts[1] ?: 'Trade';
$controllerName = '\\App\\Controllers\\' . $controllerName. 'Controller';
$actionName = @$parts[2] ?: 'index';


$controller = new $controllerName;

try {
    $controller->$actionName();
}
catch (\DomainException $e) {
    echo  $e->getMessage();
    die;
}
