<?php
// Head + Header (layout geral)
require BASE_PATH . 'includes/head.php';
require BASE_PATH . 'includes/header.php';
?>

<main class="container">
    <h1>Relatório de Ativos — Preço Médio</h1>

    <section class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Ativo</th>
                    <th>Total Comprado</th>
                    <th>Preço Médio (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($relatorio)): ?>
                <tr>
                    <td colspan="3" class="text-center">
                        Nenhum ativo encontrado.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($relatorio as $linha): ?>
                <tr>
                    <td><?= htmlspecialchars($linha['ativo']) ?></td>
                    <td><?= (int) $linha['total_quantidade'] ?></td>
                    <td><?= number_format($linha['preco_medio'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require BASE_PATH . 'includes/footer.php'; ?>