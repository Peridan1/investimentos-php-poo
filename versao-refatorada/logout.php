<?php
// A sessão já está ativa via bootstrap (config.php)

// Destroi a sessão do usuário
session_unset();
session_destroy();

// Redireciona para a tela de login
header('Location: /login');
exit;