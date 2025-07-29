<?php
require_once __DIR__ . '/../config/config.php';

$mensagemErro = '';
$noticias = [];
$termoUsado = '';
$idiomaUsado = '';

try {
    $newsService = new NewsService();
    $resultado = $newsService->getFinancialNews();
    $noticias = $resultado['artigos'];
    $termoUsado = $resultado['termo'];
    $idiomaUsado = $resultado['idioma'];
} catch (Exception $e) {
    $mensagemErro = $e->getMessage();
}

$title = "Notícias do Mercado | " . APP_NAME;
include BASE_PATH . 'includes/head.php';
?>

<body>
    <?php include BASE_PATH . 'includes/header.php'; ?>

    <main class="container">
        <h1>Notícias do Mercado Financeiro</h1>

        <?php if (!empty($noticias) && DEBUG): ?>
        <p style="color: #666; font-size: 0.9em;">
            Fonte: termo <code><?= htmlspecialchars($termoUsado) ?></code>,
            idioma <code><?= htmlspecialchars($idiomaUsado) ?></code>.
        </p>
        <?php endif; ?>

        <?php if (!empty($mensagemErro)): ?>
        <p style="color: red; font-weight: bold;">Erro: <?= htmlspecialchars($mensagemErro) ?></p>
        <?php if (DEBUG): ?>
        <p style="color: #b00;">Verifique a chave <code>NEWS_API_KEY</code> no arquivo <strong>.env</strong> ou
            possíveis problemas de conexão.</p>
        <?php endif; ?>

        <?php elseif (empty($noticias)): ?>
        <p>Não foi possível carregar as notícias no momento.</p>
        <?php if (DEBUG): ?>
        <p style="color: #b00;">DEBUG: Nenhuma notícia foi retornada pela API. Verifique o <code>error_log</code> do
            PHP.</p>
        <?php endif; ?>
        <?php else: ?>
        <div class="cards">
            <?php foreach ($noticias as $noticia): ?>
            <div class="card">
                <h2><?= htmlspecialchars($noticia['title']) ?></h2>
                <p><?= htmlspecialchars($noticia['description'] ?? 'Sem descrição disponível.') ?></p>
                <?php if (!empty($noticia['url'])): ?>
                <a href="<?= htmlspecialchars($noticia['url']) ?>" target="_blank">Ler mais</a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </main>

    <?php include BASE_PATH . 'includes/footer.php'; ?>
</body>