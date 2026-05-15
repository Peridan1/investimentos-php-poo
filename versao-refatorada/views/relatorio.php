<?php
// Dados injetados pelo RelatorioController:
// $mensagemErro, $dadosGrafico, $title

require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <h1 class="mb-4">Relatório — Investimentos x Dividendos</h1>

    <!-- Exibição de erros -->
    <?php if (!empty($mensagemErro)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($mensagemErro) ?>
    </div>

    <?php if (DEBUG): ?>
    <p class="text-muted small">
        DEBUG: verifique logs ou serviço RelatorioService.
    </p>
    <?php endif; ?>

    <!-- Sem dados -->
    <?php elseif (empty($dadosGrafico)): ?>
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <i class="fas fa-chart-bar fa-3x mb-3"></i>
            <p>Nenhum dado disponível para gerar o relatório.</p>
        </div>
    </div>

    <?php else: ?>
    <div class="card">
        <div class="card-header"><h6 class="mb-0">Investimentos vs Dividendos</h6></div>
        <div class="card-body">
            <canvas id="graficoInvestimentosDividendos"></canvas>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Script do Gráfico -->
<?php if (!empty($dadosGrafico)): ?>
<script>
const dadosPHP = <?= json_encode($dadosGrafico) ?>;

const labels = Object.keys(dadosPHP);
const dadosInvestidos = labels.map(ativo => dadosPHP[ativo].investido);
const dadosDividendos = labels.map(ativo => dadosPHP[ativo].dividendos);

const ctx = document
    .getElementById('graficoInvestimentosDividendos')
    .getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels,
        datasets: [{
                label: 'Total Investido (R$)',
                data: dadosInvestidos,
                backgroundColor: 'rgba(44, 123, 229, 0.5)',
                borderColor: '#2c7be5',
                borderWidth: 1,
                borderRadius: 4
            },
            {
                label: 'Dividendos Recebidos (R$)',
                data: dadosDividendos,
                backgroundColor: 'rgba(0, 210, 122, 0.5)',
                borderColor: '#00d27a',
                borderWidth: 1,
                borderRadius: 4
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
<?php endif; ?>

<?php require BASE_PATH . 'includes/footer.php'; ?>