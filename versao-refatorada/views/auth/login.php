<?php
// A sessão e o config já são carregados pelo bootstrap (config.php)

$title = "Login | " . APP_NAME;

// Lógica de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $usuario = new Usuario();
    $login = $usuario->validarLogin($_POST['email'], $_POST['senha']);

    if ($login) {
        session_regenerate_id(true);
        $_SESSION['usuario'] = $login;
        header("Location: /dashboard");
        exit;
    } else {
        $_SESSION['flash']['erro'] = 'Credenciais inválidas. Tente novamente.';
    }
}

require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body p-4">
                    <h1 class="mb-4 text-center h4">Entrar</h1>

                    <?php include BASE_PATH . 'includes/alert.php'; ?>

                    <form method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="/registro" class="text-muted small">Criar conta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . 'includes/footer.php'; ?>