<?php
require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <h1>Cadastro e Listagem de Dividendos</h1>

    <!-- Mensagens de Sucesso/Erro -->
    <?php if (!empty($mensagem)): ?>
    <div class="alert <?= isset($resultado) && $resultado ? 'alert-success' : 'alert-danger' ?>">
        <?= htmlspecialchars($mensagem) ?>
    </div>
    <?php endif; ?>

    <!-- Formulário de Cadastro -->
    <div class="card">
        <div class="card-header"><h6 class="mb-0">Novo Dividendo</h6></div>
        <div class="card-body">
            <form method="post" action="/dividendos" class="row g-3">
                <?= csrf_field() ?>
                <input type="hidden" name="acao" value="cadastrar">

                <div class="col-md-4">
                    <label for="ativo" class="form-label">Ativo:</label>
                    <input type="text" class="form-control" name="ativo" id="ativo" required>
                </div>

                <div class="col-md-4">
                    <label for="valor" class="form-label">Valor Recebido (R$):</label>
                    <input type="number" class="form-control" name="valor" id="valor" step="0.01" required>
                </div>

                <div class="col-md-4">
                    <label for="data_recebimento" class="form-label">Data de Recebimento:</label>
                    <input type="date" class="form-control" name="data_recebimento" id="data_recebimento" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Filtro de Período -->
    <div class="card">
        <div class="card-header"><h6 class="mb-0">Filtrar Dividendos</h6></div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-4">
                    <label for="data_inicio" class="form-label">Data Início:</label>
                    <input type="date" class="form-control" name="data_inicio" id="data_inicio" value="<?= htmlspecialchars($dataInicio ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label for="data_fim" class="form-label">Data Fim:</label>
                    <input type="date" class="form-control" name="data_fim" id="data_fim" value="<?= htmlspecialchars($dataFim ?? '') ?>">
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-filter me-1"></i> Filtrar</button>
                    <a href="/dividendos" class="btn btn-outline-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Listagem de Dividendos -->
    <div class="card">
        <div class="card-header"><h6 class="mb-0">Lista de Dividendos</h6></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
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
                            <td colspan="5" class="text-center text-muted py-4">Nenhum dividendo encontrado.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($lista as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= htmlspecialchars($item['ativo']) ?></td>
                            <td><?= number_format((float)$item['valor'], 2, ',', '.') ?></td>
                            <td><?= date('d/m/Y', strtotime($item['data_recebimento'])) ?></td>
                            <td>
                                <a href="/dividendos/editar?id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <form method="post" action="/dividendos/<?= $item['id'] ?>/delete" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir este dividendo?')">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </form>
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