<?php
/**
 * View: Dashboard
 *
 * Dados injetados pelo DashboardController:
 *   $resumo         — array com totais (totalDividendos, etc.)
 *   $grafico        — array com labels/values para Chart.js
 *   $inicio, $fim   — período de análise
 *   $totalInvestido  — string formatada em BRL
 *   $title           — título da página
 */

require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">

    <!-- ====== Cards de Resumo ====== -->
    <div class="row g-3 mb-3">

        <!-- Total Investido -->
        <div class="col-md-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 text-muted">
                            Total Investido
                            <i class="far fa-question-circle text-light ms-1" title="Soma de todas as compras"></i>
                        </h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <h3 class="mb-1">R$ <?= htmlspecialchars($totalInvestido) ?></h3>
                            <span class="badge bg-soft-success text-success-custom fw-semibold">
                                <i class="fas fa-wallet"></i> Patrimônio
                            </span>
                        </div>
                        <div class="flex-grow-1 d-flex align-items-end justify-content-end" style="height: 40px;">
                            <div class="bg-primary chart-bar-sm" style="height: 30%;"></div>
                            <div class="bg-primary chart-bar-sm" style="height: 50%;"></div>
                            <div class="bg-primary chart-bar-sm" style="height: 70%;"></div>
                            <div class="bg-primary chart-bar-sm" style="height: 40%;"></div>
                            <div class="bg-primary chart-bar-sm" style="height: 60%;"></div>
                            <div class="bg-primary chart-bar-sm" style="height: 80%;"></div>
                            <div class="bg-primary chart-bar-sm" style="height: 60%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total de Dividendos -->
        <div class="col-md-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 text-muted">Total de Dividendos</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <h3 class="mb-1">R$ <?= number_format($resumo['totalDividendos'] ?? 0, 2, ',', '.') ?></h3>
                            <span class="badge bg-soft-primary text-primary-custom fw-semibold">
                                <i class="fas fa-calendar-alt"></i>
                                <?= htmlspecialchars($inicio) ?> a <?= htmlspecialchars($fim) ?>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <svg height="40" preserveAspectRatio="none" viewBox="0 0 100 40" width="100%">
                                <path d="M0,35 Q20,35 40,30 T70,10 T100,5" fill="none" stroke="#2c7be5" stroke-width="2"></path>
                                <path d="M0,35 Q20,35 40,30 T70,10 T100,5 L100,40 L0,40 Z" fill="rgba(44, 123, 229, 0.1)" stroke="none"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribuição por Ativo -->
        <div class="col-md-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="mb-3 text-muted">Distribuição por Ativo</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <?php
                            $precos = $resumo['precos'] ?? [];
                            $cores = ['bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger'];
                            $topAtivos = array_slice($precos, 0, 3);
                            foreach ($topAtivos as $i => $item): ?>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="d-inline-block rounded-circle <?= $cores[$i % count($cores)] ?> me-2"
                                          style="width:8px; height:8px;"></span>
                                    <small><?= htmlspecialchars($item['ativo']) ?></small>
                                </div>
                            <?php endforeach; ?>
                            <?php if (empty($topAtivos)): ?>
                                <small class="text-muted">Nenhum ativo</small>
                            <?php endif; ?>
                        </div>
                        <div class="position-relative" style="width: 70px; height: 70px;">
                            <svg style="width: 100%; height: 100%;" viewBox="0 0 36 36">
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                      fill="none" stroke="#edf2f9" stroke-width="3"></path>
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                      fill="none" stroke="#2c7be5" stroke-dasharray="60, 100" stroke-width="3"></path>
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                      fill="none" stroke="#27bcfd" stroke-dasharray="20, 100" stroke-dashoffset="-60" stroke-width="3"></path>
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle fw-bold small">
                                <?= count($precos) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="col-md-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 text-muted">Ações Rápidas</h6>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="/compras/cadastrar" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i> Nova Compra
                        </a>
                        <a href="/dividendos" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-hand-holding-usd me-1"></i> Registrar Dividendo
                        </a>
                        <a href="/relatorio" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-file-alt me-1"></i> Ver Relatório
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- ====== Fim Cards de Resumo ====== -->

    <!-- ====== Seção Inferior ====== -->
    <div class="row g-3 mb-3">

        <!-- Tabela: Resumo por Ativo -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Resumo por Ativo</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-sm mb-0 align-middle">
                            <tbody>
                                <?php if (!empty($precos)): ?>
                                    <?php foreach ($precos as $i => $ativo): ?>
                                        <?php
                                        $totalGeral = array_sum(array_column($precos, 'total_valor'));
                                        $percentual = $totalGeral > 0 ? round(($ativo['total_valor'] / $totalGeral) * 100) : 0;
                                        $corBarra = $cores[$i % count($cores)];
                                        $bgSoft = ['bg-soft-primary', 'bg-soft-info', 'bg-soft-warning', 'bg-soft-success', 'bg-soft-danger'];
                                        ?>
                                        <tr class="border-bottom border-light">
                                            <td class="ps-3 py-3" style="width: 50px;">
                                                <div class="icon-box <?= $bgSoft[$i % count($bgSoft)] ?> fw-bold">
                                                    <?= strtoupper(mb_substr($ativo['ativo'], 0, 1)) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">
                                                    <?= htmlspecialchars($ativo['ativo']) ?>
                                                    <span class="badge bg-light text-muted ms-2 fw-normal" style="font-size: 0.7rem;">
                                                        <?= $percentual ?>%
                                                    </span>
                                                </h6>
                                            </td>
                                            <td class="text-end text-muted small">
                                                R$ <?= number_format($ativo['total_valor'], 2, ',', '.') ?>
                                            </td>
                                            <td class="pe-3" style="width: 100px;">
                                                <div class="progress progress-bar-custom bg-light">
                                                    <div class="progress-bar <?= str_replace('bg-soft-', 'bg-', $bgSoft[$i % count($bgSoft)]) ?>"
                                                         role="progressbar"
                                                         style="width: <?= $percentual ?>%"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Nenhum ativo registrado.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light text-center py-2 border-top-0 rounded-bottom">
                    <a class="text-primary small text-decoration-none" href="/ativos">
                        Ver todos os ativos <i class="fas fa-chevron-right ms-1" style="font-size: 0.7rem;"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Gráfico: Dividendos por Ativo -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Dividendos por Ativo</h6>
                    <span class="text-muted small">
                        <?= htmlspecialchars($inicio) ?> — <?= htmlspecialchars($fim) ?>
                    </span>
                </div>
                <div class="card-body d-flex flex-column justify-content-end p-3">
                    <canvas id="chartDividendos" style="max-height: 260px;"></canvas>
                </div>
            </div>
        </div>

    </div>
    <!-- ====== Fim Seção Inferior ====== -->


</div>

<!-- Chart.js: Dividendos por Ativo -->
<script>
    const ctx = document.getElementById('chartDividendos').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($grafico['labels'] ?? []) ?>,
            datasets: [{
                label: 'Dividendos (R$)',
                data: <?= json_encode($grafico['values'] ?? []) ?>,
                backgroundColor: 'rgba(44, 123, 229, 0.5)',
                borderColor: '#2c7be5',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                        }
                    }
                }
            }
        }
    });
</script>

<?php require BASE_PATH . 'includes/footer.php'; ?>