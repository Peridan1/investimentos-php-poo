<?php
// Head + Header
require BASE_PATH . 'includes/head.php';
require BASE_PATH . 'includes/header.php';
?>

<main class="container">
    <h1>Cadastrar Compra</h1>

    <?php if (!empty($mensagem)): ?>
    <p class="text-success"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="POST" action="/compras/cadastrar">
        <label for="ativo">Ativo:</label>
        <input type="text" name="ativo" id="ativo" required><br>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" required><br>

        <label for="valor_unitario">Valor Unitário:</label>
        <input type="number" step="0.01" name="valor_unitario" id="valor_unitario" required><br>

        <label for="data_compra">Data da Compra:</label>
        <input type="date" name="data_compra" id="data_compra" required><br>

        <button type="submit">Cadastrar</button>
    </form>
</main>

<?php require BASE_PATH . 'includes/footer.php'; ?>