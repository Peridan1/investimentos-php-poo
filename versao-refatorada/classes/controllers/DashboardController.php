<?php

class DashboardController
{
    /**
     * GET / e GET /dashboard
     */
    public function index(): void
    {
        requireAuth();

        $relatorio = new RelatorioService();

        // Período (pode vir via GET futuramente)
        $inicio = $_GET['inicio'] ?? '2025-03-01';
        $fim    = $_GET['fim']    ?? '2025-03-31';

        $resumo  = $relatorio->getResumoGeral($inicio, $fim);
        $grafico = $relatorio->getGraficoDividendos($inicio, $fim);

        $totalInvestido = calcularTotalInvestido();

        $title = "Dashboard | " . APP_NAME;

        require VIEW_PATH . 'dashboard.php';
    }
}
