<?php
require_once __DIR__ . '/../routes.php';

$dividendo = new Dividendo();
$mensagem  = '';
$id        = $_GET['id'] ?? null;

if (!$id) {
    // Se não houver ID na URL, redireciona de volta para dividendos.php
    header("Location: " . ROUTE_DIVIDENDOS);
    exit;
}

// Busca o dividendo pelo ID
$registro = $dividendo->buscarPorId((int)$id);

if (!$registro) {
    $mensagem = "Dividendo não encontrado.";
}

// Se o formulário de edição for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'editar') {
    $resultado = $dividendo->atualizarDividendo(
        (int)$id,
        $_POST['ativo'],
        (float)$_POST['valor'],
        $_POST['data_recebimento']
    );

    if ($resultado) {
        header("Location: dividendos.php?msg=Dividendo atualizado com sucesso");
        exit;
    } else {
        $mensagem = "Erro ao atualizar o dividendo.";
    }
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

        <?php if ($registro): ?>
        <form method="post" class="form-editar">
            <input type="hidden" name="acao" value="editar">

            <label for="ativo">Ativo:</label>
            <input type="text" name="ativo" id="ativo" value="<?= htmlspecialchars($registro['ativo']) ?>" required>

            <label for="valor">Valor Recebido (R$):</label>
            <input type="number" name="valor" id="valor" step="0.01"
                value="<?= number_format((float)$registro['valor'], 2, '.', '') ?>" required>

            <label for="data_recebimento">Data de Recebimento:</label>
            <input type="date" name="data_recebimento" id="data_recebimento"
                value="<?= $registro['data_recebimento'] ?>" required>

            <button type="submit">Salvar Alterações</button>
            <a href="<?= ROUTE_DIVIDENDOS ?>" class="btn-voltar">Voltar</a>
        </form>
        <?php endif; ?>
    </main>

    <?php include BASE_PATH . 'includes/footer.php'; ?>
</body>