<?php
require_once dirname(__DIR__) . '/app/bootstrap.php';

$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);
