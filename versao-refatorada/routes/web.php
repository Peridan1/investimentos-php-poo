<?php

$router->get('/', function () {
    require __DIR__ . '/../views/dashboard.php';
});

$router->get('/usuarios', function () {
    require __DIR__ . '/../views/usuarios.php';
});

$router->get('/cotacoes', function () {
    require __DIR__ . '/../views/cotas.php';
});

$router->get('/dividendos', function () {
    require __DIR__ . '/../views/dividendos.php';
});

$router->get('/relatorio', function () {
    require __DIR__ . '/../views/relatorio.php';
});