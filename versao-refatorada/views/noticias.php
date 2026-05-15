<?php
// Dados injetados pelo NoticiaController:
// $mensagemErro, $noticias, $termoUsado, $idiomaUsado, $title

require BASE_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <h1 class="mb-4">Notícias do Mercado Financeiro</h1>

    <!-- Debug info -->
    <?php if (!empty($noticias) && DEBUG): ?>
    <p class="text-muted small">
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
    <p class="text-muted small">
        Verifique a chave <code>NEWS_API_KEY</code> no arquivo <strong>.env</strong>
        ou problemas de conexão.
    </p>
    <?php endif; ?>

    <!-- Sem notícias -->
    <?php elseif (empty($noticias)): ?>
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <i class="far fa-newspaper fa-3x mb-3"></i>
            <p>Não foi possível carregar as notícias no momento.</p>
        </div>
    </div>

    <?php if (DEBUG): ?>
    <p class="text-muted small mt-2">
        DEBUG: Nenhuma notícia foi retornada pela API. Verifique o <code>error_log</code>.
    </p>
    <?php endif; ?>

    <!-- Lista de Notícias -->
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($noticias as $noticia): ?>
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title"><?= htmlspecialchars($noticia['title']) ?></h6>
                    <p class="card-text text-muted small flex-grow-1">
                        <?= htmlspecialchars($noticia['description'] ?? 'Sem descrição disponível.') ?>
                    </p>
                    <?php if (!empty($noticia['url'])): ?>
                    <a class="btn btn-sm btn-outline-primary mt-auto" href="<?= htmlspecialchars($noticia['url']) ?>" target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i> Ler mais
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php require BASE_PATH . 'includes/footer.php'; ?>