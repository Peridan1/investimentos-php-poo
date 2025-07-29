<?php
$isLogado = isset($_SESSION['usuario']);
$nomeUsuario = $isLogado ? $_SESSION['usuario']['nome'] : null;
?>

<header>
    <nav>
        <ul class="menu">
            <li><a href="<?= BASE_URL ?>index.php">Início</a></li>
            <li><a href="<?= BASE_URL ?>views/compras.php">Compras</a></li>
            <li><a href="<?= BASE_URL ?>views/ativo.php">Preço Médio</a></li>
            <li><a href="<?= BASE_URL ?>views/dividendos.php">Dividendos</a></li>
            <li><a href="<?= BASE_URL ?>views/relatorio.php">Relatório</a></li>
            <li><a href="<?= BASE_URL ?>views/noticias.php">Notícias</a></li>

            <?php if ($isLogado): ?>
                <li><a href="<?= BASE_URL ?>views/usuarios.php">Usuários</a></li>
                <li><span>Olá, <?= htmlspecialchars($nomeUsuario) ?></span></li>
                <li><a href="<?= BASE_URL ?>logout.php">Sair</a></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL ?>views/auth/login.php">Login</a></li>
                <li><a href="<?= BASE_URL ?>views/auth/registro.php">Registro</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>