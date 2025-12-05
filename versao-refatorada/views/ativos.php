<?php
// Head + Header (layout geral)
require BASE_PATH . 'includes/head.php';
require BASE_PATH . 'includes/header.php';
?>

<main class="container my-4">
    <header class="mb-4">
        <h1 class="text-center">Lista de Ativos — Preço Médio</h1>
    </header>

    <section class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Ativo</th>
                        <th scope="col" class="text-center">Quantidade Total</th>
                        <th scope="col" class="text-end">Valor Total (R$)</th>
                        <th scope="col" class="text-end">Preço Médio (R$)</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ativos)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">
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
                                        Ver Detalhes
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require BASE_PATH . 'includes/footer.php'; ?>