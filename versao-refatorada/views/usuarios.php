<?php require BASE_PATH . 'includes/header.php'; ?>

<div class="container-fluid p-0">
    <h1 class="mb-4">Gerenciar Usuários</h1>
    <p class="text-muted">Visualize, edite ou exclua usuários cadastrados no sistema.</p>

    <?php if ($mensagem): ?>
    <div class="alert alert-<?= $tipo === 'sucesso' ? 'success' : 'danger' ?>">
        <?= htmlspecialchars($mensagem) ?>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header"><h6 class="mb-0">Usuários Cadastrados</h6></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
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
                            <td colspan="5" class="text-center text-muted py-4">Nenhum usuário cadastrado</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($usuarios as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['nome']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= date('d/m/Y', strtotime($user['criado_em'])) ?></td>

                            <td class="d-flex gap-2">
                                <form method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="excluir"
                                        onclick="return confirm('Excluir este usuário?')" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </form>

                                <a href="/usuarios/editar?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . 'includes/footer.php'; ?>