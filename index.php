<?php

ob_start();

require __DIR__ . "/vendor/autoload.php";

error();

use CoffeeCode\Router\Router;

$router = new Router(url(), ":");

$router->namespace("PaginaEmConstrucao\Controller");
$router->get("/", "Web:days");
$router->get("/dias/{days}", "Web:days");

$router->namespace("PaginaEmConstrucao\Controller")->group("/json");
$router->post("/dias/{days}", "Json:days");

$router->namespace("PaginaEmConstrucao\Controller")->group("/error");
$router->get("/{errorCode}", "Web:error");

$router->dispatch();

if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}

ob_end_flush();
