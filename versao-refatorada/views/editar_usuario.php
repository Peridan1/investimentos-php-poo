<?php
// Os dados são carregados aqui pois a rota usa closure
$usuarioObj = new Usuario();
$usuarioSelecionado = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $usuarioSelecionado = $usuarioObj->buscarUsuario((int) $_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioObj->atualizarUsuario((int) $_POST['id'], $_POST['nome'], $_POST['email']);
    header('Location: /usuarios');
    exit;
}

$title = "Editar Usuário | " . APP_NAME;
include BASE_PATH . 'includes/head.php';
?>

<body>
    <?php include BASE_PATH . 'includes/header.php'; ?>

    <main class="container py-5">
        <h1 class="mb-4">Editar Usuário</h1>

        <div class="card p-4 max-w-md mx-auto">
            <form method="POST">
                <input type="hidden" name="id" value="<?= $usuarioSelecionado['id'] ?? '' ?>">

                <div class="form-group mb-3">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" name="nome" id="nome"
                        value="<?= htmlspecialchars($usuarioSelecionado['nome'] ?? '') ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="<?= htmlspecialchars($usuarioSelecionado['email'] ?? '') ?>" required>
                </div>

                <div class="form-group mb-4">
                    <label for="senha">Senha (deixe em branco para não alterar)</label>
                    <input type="password" class="form-control" name="senha" id="senha">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="/usuarios" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <?php include BASE_PATH . 'includes/footer.php'; ?>
</body>