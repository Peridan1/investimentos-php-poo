<?php
require_once __DIR__ . '/../config/config.php';
require_once BASE_PATH . 'classes/CotaService.php';

$service = new CotaService();
$cotacoes = $service->getCotacao('USD-BRL,EUR-BRL,BTC-BRL'); // múltiplas moedas

$title = "Cotações | " . APP_NAME;
include BASE_PATH . 'includes/head.php';
?>

<body>
    <?php include BASE_PATH . 'includes/header.php'; ?>

    <main class="container">
        <h1>Cotações Atualizadas</h1>

        <?php if (empty($cotacoes)): ?>
        <p>Não foi possível carregar as cotações no momento. Tente novamente mais tarde.</p>
        <?php else: ?>
        <!-- Tabela de Cotações -->
        <section>
            <h2>Tabela de Cotações</h2>
            <table class="border">
                <thead>
                    <tr>
                        <th>Moeda</th>
                        <th>Alta (R$)</th>
                        <th>Baixa (R$)</th>
                        <th>Última (R$)</th>
                        <th>Atualizado em</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cotacoes as $sigla => $info): ?>
                    <tr>
                        <td><?= htmlspecialchars($info['name']) ?></td>
                        <td><?= number_format((float)$info['high'], 2, ',', '.') ?></td>
                        <td><?= number_format((float)$info['low'], 2, ',', '.') ?></td>
                        <td><?= number_format((float)$info['bid'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($info['create_date'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Gráfico -->
        <section style="margin-top: 40px;">
            <h2>Gráfico de Variação</h2>
            <canvas id="graficoCotas"></canvas>
        </section>
        <?php endif; ?>
    </main>

    <script>
    <?php if (!empty($cotacoes)): ?>
    const labels = <?= json_encode(array_column($cotacoes, 'name')) ?>;
    const altas = <?= json_encode(array_map('floatval', array_column($cotacoes, 'high'))) ?>;
    const baixas = <?= json_encode(array_map('floatval', array_column($cotacoes, 'low'))) ?>;
    const ultimas = <?= json_encode(array_map('floatval', array_column($cotacoes, 'bid'))) ?>;

    const ctx = document.getElementById('graficoCotas').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Alta (R$)',
                    data: altas,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Baixa (R$)',
                    data: baixas,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Última (R$)',
                    data: ultimas,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    <?php endif; ?>
    </script>

    <?php include BASE_PATH . 'includes/footer.php'; ?>
</body>