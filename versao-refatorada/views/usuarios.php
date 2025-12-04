<?php include BASE_PATH . 'includes/head.php'; ?>


<?php include BASE_PATH . 'includes/header.php'; ?>

<main>
    <section class="dashboard">

        <h1>Gerenciar Usuários</h1>
        <p>Visualize, edite ou exclua usuários cadastrados no sistema.</p>

        <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipo === 'sucesso' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($mensagem) ?>
        </div>
        <?php endif; ?>

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
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="excluir"
                                        onclick="return confirm('Excluir este usuário?')" class="btn btn-delete">
                                        Excluir
                                    </button>
                                </form>

                                <a href="/usuarios/editar?id=<?= $user['id'] ?>" class="btn btn-edit">
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