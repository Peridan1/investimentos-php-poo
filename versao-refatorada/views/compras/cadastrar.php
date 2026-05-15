<?php
// Head + Header
require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <h1 class="mb-4">Cadastrar Compra</h1>

    <?php if (!empty($mensagem)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <div class="card" style="max-width: 700px;">
        <div class="card-body">
            <form method="POST" action="/compras/cadastrar" class="row g-3">
                <?= csrf_field() ?>

                <div class="col-md-6">
                    <label for="ativo" class="form-label">Ativo:</label>
                    <input type="text" class="form-control" name="ativo" id="ativo" required>
                </div>

                <div class="col-md-6">
                    <label for="quantidade" class="form-label">Quantidade:</label>
                    <input type="number" class="form-control" name="quantidade" id="quantidade" required>
                </div>

                <div class="col-md-6">
                    <label for="valor_unitario" class="form-label">Valor Unitário:</label>
                    <input type="number" step="0.01" class="form-control" name="valor_unitario" id="valor_unitario" required>
                </div>

                <div class="col-md-6">
                    <label for="data_compra" class="form-label">Data da Compra:</label>
                    <input type="date" class="form-control" name="data_compra" id="data_compra" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require BASE_PATH . 'includes/footer.php'; ?>