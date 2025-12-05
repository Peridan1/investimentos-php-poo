<?php
// Head + Header (layout geral)
require BASE_PATH . 'includes/head.php';
require BASE_PATH . 'includes/header.php';
?>

<main class="container my-4">
    <header class="mb-4">
        <h1 class="text-center">Relatório de Ativos — Preço Médio</h1>
    </header>

    <!-- Filtro de período (só aparece se estivermos no relatório geral) -->
    <?php if (isset($relatorio)): ?>
    <form method="get" action="/ativo" class="row g-3 mb-4">
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
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
    <?php endif; ?>

    <section class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Ativo</th>
                        <th scope="col" class="text-center">Total Comprado</th>
                        <th scope="col" class="text-end">Preço Médio (R$)</th>
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


                    <!-- Botão de voltar -->
                    <div class="mt-3">
                        <a href="/ativos" class="btn btn-secondary">← Voltar para lista de ativos</a>
                    </div>
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
                        <td colspan="3" class="text-center text-muted">
                            Nenhum ativo encontrado.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require BASE_PATH . 'includes/footer.php'; ?>