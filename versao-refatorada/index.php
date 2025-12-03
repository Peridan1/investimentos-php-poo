<?php

require __DIR__ . '/config/config.php';
require __DIR__ . '/classes/Router.php';

// Instancia o roteador
$router = new Router();

// Carrega rotas
require __DIR__ . '/routes/web.php';
require __DIR__ . '/routes/auth.php';
require __DIR__ . '/routes/api.php';

// Despacha
$router->dispatch(BASE_PATH);

require_once __DIR__ . '/routes.php';

header('Location: ' . ROUTE_DASHBOARD);
exit;
