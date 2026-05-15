<?php

class CotaController
{
    /**
     * GET /cotas
     */
    public function index(): void
    {
        $service = new CotaService();
        $cotacoes = $service->getCotacao('USD-BRL,EUR-BRL,BTC-BRL');

        $title = "Cotações | " . APP_NAME;

        require VIEW_PATH . 'cotas.php';
    }
}
