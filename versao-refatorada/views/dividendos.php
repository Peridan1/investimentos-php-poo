<?php
require BASE_PATH . 'includes/head.php';
require BASE_PATH . 'includes/header.php';
?>

<main class="container">
    <h1>Cadastro e Listagem de Dividendos</h1>

    <!-- Mensagens de Sucesso/Erro -->
    <?php if (!empty($mensagem)): ?>
    <div class="alert <?= isset($resultado) && $resultado ? 'alert-success' : 'alert-danger' ?>">
        <?= htmlspecialchars($mensagem) ?>
    </div>
    <?php endif; ?>

    <!-- Formulário de Cadastro -->
    <section class="card">
        <h2>Novo Dividendo</h2>

        <form method="post" class="form-cadastro">
            <input type="hidden" name="acao" value="cadastrar">

            <label for="ativo">Ativo:</label>
            <input type="text" name="ativo" id="ativo" required>

            <label for="valor">Valor Recebido (R$):</label>
            <input type="number" name="valor" id="valor" step="0.01" required>

            <label for="data_recebimento">Data de Recebimento:</label>
            <input type="date" name="data_recebimento" id="data_recebimento" required>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </section>

    <!-- Filtro de Período -->
    <section class="card">
        <h2>Filtrar Dividendos</h2>

        <form method="get" class="filtro-data">
            <label for="data_inicio">Data Início:</label>
            <input type="date" name="data_inicio" id="data_inicio" value="<?= htmlspecialchars($dataInicio ?? '') ?>">

            <label for="data_fim">Data Fim:</label>
            <input type="date" name="data_fim" id="data_fim" value="<?= htmlspecialchars($dataFim ?? '') ?>">

            <button type="submit" class="btn btn-secondary">Filtrar</button>

            <!-- Importante: voltar para a rota, não para arquivo -->
            <a href="/dividendos" class="btn btn-outline">Limpar</a>
        </form>
    </section>

    <!-- Listagem de Dividendos -->
    <section class="card">
        <h2>Lista de Dividendos</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ativo</th>
                    <th>Valor (R$)</th>
                    <th>Data de Recebimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($lista)): ?>
                <tr>
                    <td colspan="5" class="text-center">Nenhum dividendo encontrado.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($lista as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['ativo']) ?></td>
                    <td><?= number_format((float)$item['valor'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($item['data_recebimento'])) ?></td>
                    <td>
                        <a href="/dividendos/editar?id=<?= $item['id'] ?>" class="btn btn-edit">Editar</a>

                        <form method="post" style="display:inline;">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">

                            <button type="submit" class="btn btn-delete"
                                onclick="return confirm('Tem certeza que deseja excluir este dividendo?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require BASE_PATH . 'includes/footer.php'; ?>