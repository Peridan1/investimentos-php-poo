<?php
// A sessão e o config já são carregados pelo bootstrap (config.php)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $usuario = new Usuario();

    try {
        $ok = $usuario->criarUsuario($_POST['nome'], $_POST['email'], $_POST['senha']);

        if (!$ok) {
            throw new Exception("Não foi possível registrar o usuário.");
        }

        session_regenerate_id(true);
        $_SESSION['usuario'] = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email']
        ];

        header('Location: /dashboard');
        exit;
    } catch (Exception $e) {
        $_SESSION['flash']['erro'] = $e->getMessage();
    }
}

$title = "Registro | " . APP_NAME;

require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body p-4">
                    <h1 class="mb-4 text-center h4">Registrar Usuário</h1>

                    <?php if (!empty($_SESSION['flash']['erro'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['flash']['erro']); ?>
                    </div>
                    <?php unset($_SESSION['flash']['erro']); ?>
                    <?php endif; ?>

                    <form method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-4">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . 'includes/footer.php'; ?>