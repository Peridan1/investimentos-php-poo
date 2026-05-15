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
require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <h1 class="mb-4">Editar Usuário</h1>

    <div class="card" style="max-width: 600px;">
        <div class="card-body">
            <form method="POST" class="row g-3">
                <input type="hidden" name="id" value="<?= $usuarioSelecionado['id'] ?? '' ?>">

                <div class="col-12">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome" id="nome"
                        value="<?= htmlspecialchars($usuarioSelecionado['nome'] ?? '') ?>" required>
                </div>

                <div class="col-12">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="<?= htmlspecialchars($usuarioSelecionado['email'] ?? '') ?>" required>
                </div>

                <div class="col-12">
                    <label for="senha" class="form-label">Senha (deixe em branco para não alterar)</label>
                    <input type="password" class="form-control" name="senha" id="senha">
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Salvar</button>
                    <a href="/usuarios" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require BASE_PATH . 'includes/footer.php'; ?>