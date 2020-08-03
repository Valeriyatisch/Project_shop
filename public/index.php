<?php
//session_id(\Val\SweetsShop\Base\Utils::generateSessionId());
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
//var_dump($_SERVER['REQUEST_URI']);

$request = new Val\SweetsShop\Base\Request();

$config = __DIR__ . '/../config.json';

$app = new Val\SweetsShop\Base\Application($config);
$response = $app->handleRequest($request);
$response->send();