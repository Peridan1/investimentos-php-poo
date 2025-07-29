<?php
require_once __DIR__ . '/../routes.php';
require_once BASE_PATH . 'includes/helpers.php';
require_once BASE_PATH . 'classes/Usuario.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ' . ROUTE_LOGIN);
    exit;
}

// Exclusão de usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'], $_POST['id'])) {
    $usuario = new Usuario();

    try {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id !== false) {
            $usuario->excluirUsuario($id);
            $_SESSION['flash']['sucesso'] = "Usuário excluído com sucesso!";
            header('Location: ' . ROUTE_USUARIOS);
            exit;
        } else {
            $_SESSION['flash']['erro'] = "ID inválido para exclusão.";
            header('Location: ' . ROUTE_USUARIOS);
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['flash']['erro'] = "Erro ao excluir usuário: " . $e->getMessage();
        header('Location: ' . ROUTE_USUARIOS);
        exit;
    }
}

// Buscar todos os usuários
$usuario = new Usuario();
$usuarios = $usuario->listarUsuarios();

$title = "Gerenciar Usuários | " . APP_NAME;
include BASE_PATH . 'includes/head.php';
?>

<body>
    <?php include BASE_PATH . 'includes/header.php'; ?>

    <main>
        <section class="dashboard">
            <h1>Gerenciar Usuários</h1>
            <p>Visualize, edite ou exclua usuários cadastrados no sistema.</p>

            <?php include BASE_PATH . 'includes/alert.php'; ?>

            <div class="card p-4">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($usuarios)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Nenhum usuário cadastrado</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($usuarios as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['nome']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= date('d/m/Y', strtotime($user['criado_em'])) ?></td>
                                <td class="d-flex gap-2">
                                    <form method="POST" class="m-0" autocomplete="off">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" name="excluir" class="btn btn-delete"
                                            onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                            Excluir
                                        </button>
                                    </form>
                                    <a href="<?= ROUTE_EDITAR_USU ?>?id=<?= $user['id'] ?>" class="btn btn-edit">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <?php include BASE_PATH . 'includes/footer.php'; ?>
</body>