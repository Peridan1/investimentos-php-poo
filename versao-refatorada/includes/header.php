<?php
/**
 * Layout Header — Falcon Theme
 *
 * Inclui: <!DOCTYPE> → <head> → Sidebar → Topbar → abertura de <main>.
 * Espera a variável $title definida pelo controller.
 */

$isLogado = isset($_SESSION['usuario']);
$nomeUsuario = $isLogado ? htmlspecialchars($_SESSION['usuario']['nome']) : 'Visitante';
$currentUri  = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($title ?? APP_NAME) ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* ===== Base ===== */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f7fa;
            color: #5e6e82;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #fff;
            border-right: 1px solid #edf2f9;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: 250px;
            padding-top: 70px;
        }

        /* ===== Topbar ===== */
        .topbar {
            height: 70px;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            background-color: #fff;
            z-index: 999;
            border-bottom: 1px solid #edf2f9;
        }

        /* ===== Navigation ===== */
        .sidebar .nav-link {
            color: #5e6e82;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #2c7be5;
            background-color: #f0f6ff;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            color: #9da9bb;
        }

        .sidebar .nav-link:hover i,
        .sidebar .nav-link.active i {
            color: #2c7be5;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #9da9bb;
            padding: 1rem 1rem 0.5rem;
            margin-top: 1rem;
        }

        /* ===== Cards ===== */
        .card {
            border: none;
            box-shadow: 0 7px 14px 0 rgba(65, 69, 88, 0.1), 0 3px 6px 0 rgba(0, 0, 0, 0.07);
            margin-bottom: 1.5rem;
            border-radius: 0.375rem;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #edf2f9;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        /* ===== Custom Colors ===== */
        .text-success-custom { color: #00d27a; }
        .text-primary-custom { color: #2c7be5; }
        .text-info-custom    { color: #27bcfd; }
        .text-warning-custom { color: #f5803e; }

        .bg-soft-success { background-color: rgba(0, 210, 122, 0.1); color: #008a50; }
        .bg-soft-primary { background-color: rgba(44, 123, 229, 0.1); color: #1a4f93; }
        .bg-soft-info    { background-color: rgba(39, 188, 253, 0.1); color: #167098; }
        .bg-soft-warning { background-color: rgba(245, 128, 62, 0.1); color: #934c25; }
        .bg-soft-danger  { background-color: rgba(230, 55, 87, 0.1);  color: #8e2135; }

        /* ===== Utilities ===== */
        .chart-bar-sm {
            width: 6px;
            border-radius: 3px;
            margin: 0 2px;
        }

        .progress-bar-custom {
            height: 6px;
            border-radius: 3px;
        }

        .avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .icon-box {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 14px;
        }

        /* ===== Responsive ===== */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .topbar {
                left: 0;
            }
        }
    </style>
</head>

<body>

<!-- BEGIN: Sidebar -->
<nav class="sidebar py-3" id="sidebarNav">
    <div class="px-3 mb-4 d-flex align-items-center">
        <button class="btn btn-link text-secondary p-0 me-2 d-lg-none" onclick="document.getElementById('sidebarNav').classList.toggle('show')">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand text-primary fw-bold fs-4 d-flex align-items-center text-decoration-none" href="/dashboard">
            <i class="fas fa-chart-line me-2"></i> <?= htmlspecialchars(APP_NAME) ?>
        </a>
    </div>

    <ul class="nav flex-column mb-auto">
        <div class="sidebar-heading">Principal</div>

        <li class="nav-item">
            <a class="nav-link<?= in_array($currentUri, ['/', '/dashboard']) ? ' active' : '' ?>" href="/dashboard">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?= str_starts_with($currentUri, '/ativos') || $currentUri === '/ativo' ? ' active' : '' ?>" href="/ativos">
                <i class="fas fa-coins"></i> Ativos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?= str_starts_with($currentUri, '/compras') ? ' active' : '' ?>" href="/compras">
                <i class="fas fa-shopping-cart"></i> Compras
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?= str_starts_with($currentUri, '/dividendos') ? ' active' : '' ?>" href="/dividendos">
                <i class="fas fa-hand-holding-usd"></i> Dividendos
            </a>
        </li>

        <div class="sidebar-heading">Análises</div>

        <li class="nav-item">
            <a class="nav-link<?= $currentUri === '/relatorio' ? ' active' : '' ?>" href="/relatorio">
                <i class="fas fa-file-alt"></i> Relatório
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?= $currentUri === '/cotas' ? ' active' : '' ?>" href="/cotas">
                <i class="fas fa-exchange-alt"></i> Cotações
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?= $currentUri === '/noticias' ? ' active' : '' ?>" href="/noticias">
                <i class="far fa-newspaper"></i> Notícias
            </a>
        </li>

        <?php if ($isLogado): ?>
        <div class="sidebar-heading">Administração</div>

        <li class="nav-item">
            <a class="nav-link<?= str_starts_with($currentUri, '/usuarios') ? ' active' : '' ?>" href="/usuarios">
                <i class="fas fa-users"></i> Usuários
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<!-- END: Sidebar -->

<!-- BEGIN: Topbar -->
<header class="topbar d-flex align-items-center px-4 justify-content-between">
    <div class="d-flex align-items-center">
        <button class="btn btn-link text-secondary p-0 me-3 d-lg-none" onclick="document.getElementById('sidebarNav').classList.toggle('show')">
            <i class="fas fa-bars"></i>
        </button>
        <div class="input-group input-group-sm" style="width: 250px;">
            <span class="input-group-text bg-light border-end-0 rounded-pill rounded-end">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input class="form-control bg-light border-start-0 rounded-pill rounded-start ps-0"
                   placeholder="Buscar..." type="text" />
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="text-muted small d-none d-md-inline">
            Olá, <strong><?= $nomeUsuario ?></strong>
        </span>
        <?php if ($isLogado): ?>
            <a class="text-secondary" href="/logout" title="Sair"><i class="fas fa-sign-out-alt"></i></a>
        <?php else: ?>
            <a class="text-secondary" href="/login" title="Entrar"><i class="fas fa-sign-in-alt"></i></a>
        <?php endif; ?>
        <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center fw-bold">
            <?= strtoupper(mb_substr($nomeUsuario, 0, 1)) ?>
        </div>
    </div>
</header>
<!-- END: Topbar -->

<!-- BEGIN: Main Content -->
<main class="main-content p-4">