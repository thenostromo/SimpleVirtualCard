<?php
include 'autoload.php';

use Router\Router;

$router = new Router();
echo $router->handleRequest();