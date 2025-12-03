<?php

$router->get('/api/compras', function () {
    header('Content-Type: application/json');
    require __DIR__ . '/../api/listar_compras.php';
});

$router->post('/api/compras', function () {
    header('Content-Type: application/json');
    require __DIR__ . '/../api/salvar_compra.php';
});