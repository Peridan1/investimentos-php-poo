<?php

$router->get('/login', function () {
    require BASE_PATH . 'views/auth/login.php';
});

$router->get('/registro', function () {
    require BASE_PATH . 'views/auth/registro.php';
});

$router->post('/registro', function () {
    require BASE_PATH . 'views/auth/registro.php';
});

$router->get('/logout', function () {
    require BASE_PATH . 'logout.php';
});