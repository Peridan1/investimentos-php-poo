<?php
// Dados injetados pelo CotaController:
// $cotacoes, $title

require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <h1 class="mb-4">Cotações Atualizadas</h1>

    <?php if (empty($cotacoes)): ?>
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <i class="fas fa-exchange-alt fa-3x mb-3"></i>
            <p>Não foi possível carregar as cotações no momento. Tente novamente mais tarde.</p>
        </div>
    </div>
    <?php else: ?>

    <!-- Tabela -->
    <div class="card">
        <div class="card-header"><h6 class="mb-0">Tabela de Cotações</h6></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Moeda</th>
                            <th class="text-end">Alta (R$)</th>
                            <th class="text-end">Baixa (R$)</th>
                            <th class="text-end">Última (R$)</th>
                            <th class="text-end">Atualizado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cotacoes as $info): ?>
                        <tr>
                            <td><?= htmlspecialchars($info['name']) ?></td>
                            <td class="text-end"><?= number_format((float)$info['high'], 2, ',', '.') ?></td>
                            <td class="text-end"><?= number_format((float)$info['low'], 2, ',', '.') ?></td>
                            <td class="text-end"><?= number_format((float)$info['bid'], 2, ',', '.') ?></td>
                            <td class="text-end"><?= date('d/m/Y H:i', strtotime($info['create_date'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="card">
        <div class="card-header"><h6 class="mb-0">Gráfico de Variação</h6></div>
        <div class="card-body">
            <canvas id="graficoCotas"></canvas>
        </div>
    </div>

    <?php endif; ?>
</div>

<?php if (!empty($cotacoes)): ?>
<script>
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
                backgroundColor: 'rgba(44, 123, 229, 0.5)',
                borderColor: '#2c7be5',
                borderWidth: 1,
                borderRadius: 4
            },
            {
                label: 'Baixa (R$)',
                data: baixas,
                backgroundColor: 'rgba(230, 55, 87, 0.5)',
                borderColor: '#e63757',
                borderWidth: 1,
                borderRadius: 4
            },
            {
                label: 'Última (R$)',
                data: ultimas,
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