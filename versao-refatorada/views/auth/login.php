<?php
require_once dirname(__DIR__, 2) . '/config/config.php';

session_start();

// Carrega helpers
require_once BASE_PATH . 'includes/helpers.php';

$title = "Login | " . APP_NAME;

// Lógica de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario();
    $login = $usuario->validarLogin($_POST['email'], $_POST['senha']);

    if ($login) {
        $_SESSION['usuario'] = $login;
        header("Location: " . '/dashboard');
        exit;
    } else {
        $_SESSION['flash']['erro'] = 'Credenciais inválidas. Tente novamente.';
    }
}

// Cabeçalho padrão
include BASE_PATH . 'includes/head.php';
?>

<body>
    <?php include BASE_PATH . 'includes/header.php'; ?>

    <main class="container py-5">
        <div class="card p-4 mx-auto" style="max-width: 420px;">
            <h1 class="mb-4 text-center">Entrar</h1>

            <?php include BASE_PATH . 'includes/alert.php'; ?>

            <form method="POST">

                <div class="form-group mb-3">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>

                <div class="form-group mb-4">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= '/registro' ?>">Criar conta</a>
            </div>
        </div>
    </main>

    <?php include BASE_PATH . 'includes/footer.php'; ?>
</body>