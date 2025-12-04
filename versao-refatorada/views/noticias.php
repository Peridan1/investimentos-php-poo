<?php
require_once __DIR__ . '/../config/config.php';

$mensagemErro = '';
$noticias = [];
$termoUsado = '';
$idiomaUsado = '';

try {
    $newsService = new NewsService();
    $resultado = $newsService->getFinancialNews();

    $noticias   = $resultado['artigos'];
    $termoUsado = $resultado['termo'];
    $idiomaUsado = $resultado['idioma'];
} catch (Exception $e) {
    $mensagemErro = $e->getMessage();
}

$title = "Notícias do Mercado | " . APP_NAME;
include BASE_PATH . 'includes/head.php';
?>


<?php include BASE_PATH . 'includes/header.php'; ?>

<main class="container">
    <h1>Notícias do Mercado Financeiro</h1>

    <!-- Debug info -->
    <?php if (!empty($noticias) && DEBUG): ?>
    <p class="debug-info">
        Fonte: termo <code><?= htmlspecialchars($termoUsado) ?></code>,
        idioma <code><?= htmlspecialchars($idiomaUsado) ?></code>.
    </p>
    <?php endif; ?>

    <!-- Mensagem de Erro -->
    <?php if (!empty($mensagemErro)): ?>
    <div class="alert alert-danger">
        Erro: <?= htmlspecialchars($mensagemErro) ?>
    </div>

    <?php if (DEBUG): ?>
    <p class="debug-info">
        Verifique a chave <code>NEWS_API_KEY</code> no arquivo <strong>.env</strong>
        ou problemas de conexão.
    </p>
    <?php endif; ?>

    <!-- Sem notícias -->
    <?php elseif (empty($noticias)): ?>
    <p>Não foi possível carregar as notícias no momento.</p>

    <?php if (DEBUG): ?>
    <p class="debug-info">
        DEBUG: Nenhuma notícia foi retornada pela API. Verifique o <code>error_log</code>.
    </p>
    <?php endif; ?>

    <!-- Lista de Notícias -->
    <?php else: ?>
    <div class="cards">
        <?php foreach ($noticias as $noticia): ?>
        <article class="card">
            <h2><?= htmlspecialchars($noticia['title']) ?></h2>

            <p>
                <?= htmlspecialchars($noticia['description'] ?? 'Sem descrição disponível.') ?>
            </p>

            <?php if (!empty($noticia['url'])): ?>
            <a class="btn btn-primary" href="<?= htmlspecialchars($noticia['url']) ?>" target="_blank">
                Ler mais
            </a>
            <?php endif; ?>
        </article>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</main>

<?php include BASE_PATH . 'includes/footer.php'; ?>