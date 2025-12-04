<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../classes/RelatorioService.php";

$mensagemErro = '';
$dadosGrafico = [];

try {
    $relatorio = new RelatorioService();
    $resumo = $relatorio->getResumoGeral();

    $investimentos = $resumo['precos'] ?? [];
    $dividendos    = $resumo['dividendos'] ?? [];

    // Montagem dos dados do gráfico
    foreach ($investimentos as $item) {
        $ativo = $item['ativo'];
        $dadosGrafico[$ativo] = [
            'investido'  => $item['total_valor'],
            'dividendos' => 0
        ];
    }

    foreach ($dividendos as $item) {
        $ativo = $item['ativo'];
        if (isset($dadosGrafico[$ativo])) {
            $dadosGrafico[$ativo]['dividendos'] = $item['total_dividendos'];
        }
    }
} catch (Exception $e) {
    $mensagemErro = "Erro ao carregar relatório: " . $e->getMessage();
}

$title = "Relatório | " . APP_NAME;
include BASE_PATH . 'includes/head.php';
?>


<?php include BASE_PATH . 'includes/header.php'; ?>

<main class="container">
    <h1>Relatório — Investimentos x Dividendos</h1>

    <!-- Exibição de erros -->
    <?php if (!empty($mensagemErro)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($mensagemErro) ?>
    </div>

    <?php if (DEBUG): ?>
    <p class="debug-info">
        DEBUG: verifique logs ou serviço RelatorioService.
    </p>
    <?php endif; ?>

    <!-- Sem dados -->
    <?php elseif (empty($dadosGrafico)): ?>
    <p>Nenhum dado disponível para gerar o relatório.</p>

    <?php else: ?>
    <div class="card p-3">
        <canvas id="graficoInvestimentosDividendos"></canvas>
    </div>
    <?php endif; ?>
</main>

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
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Dividendos Recebidos (R$)',
                data: dadosDividendos,
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
</script>
<?php endif; ?>

<?php include BASE_PATH . 'includes/footer.php'; ?>