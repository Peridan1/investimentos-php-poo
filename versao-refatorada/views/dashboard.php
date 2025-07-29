<?php
// 1. Bootstrap global (autoload + env + DB)
require_once dirname(__DIR__) . '/config/config.php';

// 2. Instâncias de serviço
$relatorio = new RelatorioService();

// 3. Período (pode vir via GET futuramente)
$inicio = '2025-03-01';
$fim    = '2025-03-31';

// 4. Dados
$resumo  = $relatorio->getResumoGeral($inicio, $fim);
$grafico = $relatorio->getGraficoDividendos($inicio, $fim);

// 5. Meta
$title = "Dashboard | Gestão de Ativos";

require_once BASE_PATH . 'includes/helpers.php';
include BASE_PATH . 'includes/head.php';
?>

<body>
    <?php include BASE_PATH . 'includes/header.php'; ?>

    <main>
        <section class="dashboard">
            <h1>Bem-vindo à Gestão de Ativos</h1>
            <p>Este sistema ajuda você a gerenciar seus investimentos em ativos.</p>

            <div class="cards">
                <div class="card">
                    <h2>Total Investido</h2>
                    <p>R$ <?= calcularTotalInvestido(); ?></p>
                </div>
                <div class="card">
                    <h2>Total de Dividendos (<?= htmlspecialchars($inicio) ?> a <?= htmlspecialchars($fim) ?>)</h2>
                    <p>R$ <?= number_format($resumo['totalDividendos'], 2, ',', '.'); ?></p>
                </div>
            </div>

            <div class="chart-container" style="max-width:600px;margin:2rem auto;">
                <canvas id="chartDividendos"></canvas>
            </div>
        </section>
    </main>

    <?php include BASE_PATH . 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartDividendos').getContext('2d');
        const chartDividendos = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($grafico['labels']); ?>,
                datasets: [{
                    label: 'Dividendos (R$)',
                    data: <?= json_encode($grafico['values']); ?>,
                    backgroundColor: 'rgba(54,162,235,0.5)',
                    borderColor: 'rgba(54,162,235,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Dividendos por Ativo'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>