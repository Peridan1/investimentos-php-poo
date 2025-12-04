<?php
$isLogado = isset($_SESSION['usuario']);
$nomeUsuario = $isLogado ? $_SESSION['usuario']['nome'] : null;
?>

<header>
    <nav>
        <ul class="menu">

            <!-- Rotas principais -->
            <li><a href="<?= BASE_URL ?>">Início</a></li>
            <li><a href="<?= BASE_URL ?>compras">Compras</a></li>
            <li><a href="<?= BASE_URL ?>ativo">Preço Médio</a></li>
            <li><a href="<?= BASE_URL ?>dividendos">Dividendos</a></li>
            <li><a href="<?= BASE_URL ?>relatorio">Relatório</a></li>
            <li><a href="<?= BASE_URL ?>noticias">Notícias</a></li>

            <?php if ($isLogado): ?>
            <li><a href="<?= BASE_URL ?>usuarios">Usuários</a></li>
            <li><span>Olá, <?= htmlspecialchars($nomeUsuario) ?></span></li>
            <li><a href="<?= BASE_URL ?>logout">Sair</a></li>
            <?php else: ?>
            <li><a href="<?= BASE_URL ?>login">Login</a></li>
            <li><a href="<?= BASE_URL ?>registro">Registro</a></li>
            <?php endif; ?>

        </ul>
    </nav>
</header>