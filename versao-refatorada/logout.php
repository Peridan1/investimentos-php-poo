<?php
session_start();

// Destroi a sessão do usuário
session_unset();
session_destroy();

// Redireciona para a tela de login
header('Location: ' . '/login');

exit;