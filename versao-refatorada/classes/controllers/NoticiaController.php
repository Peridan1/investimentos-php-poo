<?php

class NoticiaController
{
    /**
     * GET /noticias
     */
    public function index(): void
    {
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

        require VIEW_PATH . 'noticias.php';
    }
}
