<?php
// Os dados ($dividendo) são injetados pelo DividendoController@show

$mensagem = '';

if (!$dividendo) {
    $mensagem = "Dividendo não encontrado.";
}

$title = "Editar Dividendo | " . APP_NAME;
include BASE_PATH . 'includes/head.php';
?>

<body>
    <?php include BASE_PATH . 'includes/header.php'; ?>

    <main class="container">
        <h1>Editar Dividendo</h1>

        <?php if (!empty($mensagem)): ?>
        <p style="color:red;"><?= $mensagem ?></p>
        <?php endif; ?>

        <?php if ($dividendo): ?>
        <form method="post" action="/dividendos/<?= $dividendo['id'] ?>/update" class="form-editar">
            <?= csrf_field() ?>
            <label for="ativo">Ativo:</label>
            <input type="text" name="ativo" id="ativo" value="<?= htmlspecialchars($dividendo['ativo']) ?>" required>

            <label for="valor">Valor Recebido (R$):</label>
            <input type="number" name="valor" id="valor" step="0.01"
                value="<?= number_format((float)$dividendo['valor'], 2, '.', '') ?>" required>

            <label for="data_recebimento">Data de Recebimento:</label>
            <input type="date" name="data_recebimento" id="data_recebimento"
                value="<?= $dividendo['data_recebimento'] ?>" required>

            <button type="submit">Salvar Alterações</button>
            <a href="/dividendos" class="btn-voltar">Voltar</a>
        </form>
        <?php endif; ?>
    </main>

    <?php include BASE_PATH . 'includes/footer.php'; ?>
</body>