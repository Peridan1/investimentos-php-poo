<?php
// Os dados ($dividendo) são injetados pelo DividendoController@show

$mensagem = '';

if (!$dividendo) {
    $mensagem = "Dividendo não encontrado.";
}

$title = "Editar Dividendo | " . APP_NAME;
require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <h1 class="mb-4">Editar Dividendo</h1>

    <?php if (!empty($mensagem)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <?php if ($dividendo): ?>
    <div class="card">
        <div class="card-body">
            <form method="post" action="/dividendos/<?= $dividendo['id'] ?>/update" class="row g-3">
                <?= csrf_field() ?>

                <div class="col-md-4">
                    <label for="ativo" class="form-label">Ativo:</label>
                    <input type="text" class="form-control" name="ativo" id="ativo" value="<?= htmlspecialchars($dividendo['ativo']) ?>" required>
                </div>

                <div class="col-md-4">
                    <label for="valor" class="form-label">Valor Recebido (R$):</label>
                    <input type="number" class="form-control" name="valor" id="valor" step="0.01"
                        value="<?= number_format((float)$dividendo['valor'], 2, '.', '') ?>" required>
                </div>

                <div class="col-md-4">
                    <label for="data_recebimento" class="form-label">Data de Recebimento:</label>
                    <input type="date" class="form-control" name="data_recebimento" id="data_recebimento"
                        value="<?= $dividendo['data_recebimento'] ?>" required>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Salvar Alterações</button>
                    <a href="/dividendos" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Voltar</a>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require BASE_PATH . 'includes/footer.php'; ?>