<?php
// A sessão e o config já são carregados pelo bootstrap (config.php)

$title = "Login | " . APP_NAME;

// Lógica de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $usuario = new Usuario();
    $login = $usuario->validarLogin($_POST['email'], $_POST['senha']);

    if ($login) {
        // Regenera o ID da sessão após login (previne session fixation)
        session_regenerate_id(true);
        $_SESSION['usuario'] = $login;
        header("Location: /dashboard");
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
                <?= csrf_field() ?>

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
                <a href="/registro">Criar conta</a>
            </div>
        </div>
    </main>

    <?php include BASE_PATH . 'includes/footer.php'; ?>
</body>