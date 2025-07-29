<?php
require_once dirname(__DIR__, 2) . '/routes.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario();

    try {
        $usuario->criarUsuario($_POST['nome'], $_POST['email'], $_POST['senha']);

        $_SESSION['usuario'] = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email']
        ];

        header('Location: ' . ROUTE_DASHBOARD);
        exit;
    } catch (Exception $e) {
        $_SESSION['flash']['erro'] = $e->getMessage();
    }
}

$title = "Registro | " . APP_NAME;
require_once BASE_PATH . 'includes/helpers.php';
include BASE_PATH . 'includes/head.php';
?>

<body>

    <?php include '../../includes/header.php'; ?>

    <main class="container py-5">
        <h1 class="mb-4 text-center">Registrar Usuário</h1>

        <div class="card p-4 max-w-md mx-auto">
            <?php if (!empty($erro)) : ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group mb-3">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group mb-4">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </main>

    <?php include '../../includes/footer.php'; ?>
</body>