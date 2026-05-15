<?php
// Head + Header (layout geral)
require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <h1 class="mb-4 text-center">Relatório de Ativos — Preço Médio</h1>

    <!-- Filtro de período (só aparece se estivermos no relatório geral) -->
    <?php if (isset($relatorio)): ?>
    <div class="card mb-3">
        <div class="card-body">
            <form method="get" action="/ativo" class="row g-3">
                <div class="col-md-4">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="form-control"
                        value="<?= htmlspecialchars($_GET['data_inicio'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control"
                        value="<?= htmlspecialchars($_GET['data_fim'] ?? '') ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrar</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ativo</th>
                            <th class="text-center">Total Comprado</th>
                            <th class="text-end">Preço Médio (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($detalhe)): ?>
                        <!-- Exibição de um ativo específico -->
                        <tr>
                            <td><?= htmlspecialchars($detalhe['ativo']) ?></td>
                            <td class="text-center"><?= (int) $detalhe['total_quantidade'] ?></td>
                            <td class="text-end"><?= number_format($detalhe['preco_medio'], 2, ',', '.') ?></td>
                        </tr>
                        <?php elseif (!empty($relatorio)): ?>
                        <!-- Exibição de vários ativos (relatório) -->
                        <?php foreach ($relatorio as $linha): ?>
                        <tr>
                            <td><?= htmlspecialchars($linha['ativo']) ?></td>
                            <td class="text-center"><?= (int) $linha['total_quantidade'] ?></td>
                            <td class="text-end"><?= number_format($linha['preco_medio'], 2, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Nenhum ativo encontrado.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if (isset($detalhe)): ?>
    <div class="mt-3">
        <a href="/ativos" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Voltar para lista de ativos</a>
    </div>
    <?php endif; ?>
</div>

<?php require BASE_PATH . 'includes/footer.php'; ?>