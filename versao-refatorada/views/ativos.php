<?php
// Head + Header (layout geral)
require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <h1 class="mb-4 text-center">Lista de Ativos — Preço Médio</h1>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ativo</th>
                            <th class="text-center">Quantidade Total</th>
                            <th class="text-end">Valor Total (R$)</th>
                            <th class="text-end">Preço Médio (R$)</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ativos)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Nenhum ativo encontrado.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ativos as $ativo): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ativo['ativo']) ?></td>
                                    <td class="text-center"><?= (int) $ativo['total_quantidade'] ?></td>
                                    <td class="text-end"><?= number_format($ativo['total_valor'], 2, ',', '.') ?></td>
                                    <td class="text-end"><?= number_format($ativo['preco_medio'], 2, ',', '.') ?></td>
                                    <td class="text-center">
                                        <a href="/ativos/<?= urlencode($ativo['ativo']) ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> Ver Detalhes
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