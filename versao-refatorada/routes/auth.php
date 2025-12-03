<?php

$router->get('/login', function () {
    require __DIR__ . '/../views/auth/login.php';
});

$router->post('/login', function () {
    require __DIR__ . '/../controllers/LoginController.php';
});

$router->get('/logout', function () {
    require __DIR__ . '/../logout.php';
});

$router->get('/registrar', function () {
    require __DIR__ . '/../views/auth/registro.php';
});