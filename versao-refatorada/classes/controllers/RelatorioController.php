<?php

class RelatorioController
{
    /**
     * GET /relatorio
     */
    public function index(): void
    {
        $mensagemErro = '';
        $dadosGrafico = [];

        try {
            $relatorio = new RelatorioService();
            $resumo = $relatorio->getResumoGeral();

            $investimentos = $resumo['precos'] ?? [];
            $dividendos    = $resumo['dividendos'] ?? [];

            // Montagem dos dados do gráfico
            foreach ($investimentos as $item) {
                $ativo = $item['ativo'];
                $dadosGrafico[$ativo] = [
                    'investido'  => $item['total_valor'],
                    'dividendos' => 0
                ];
            }

            foreach ($dividendos as $item) {
                $ativo = $item['ativo'];
                if (isset($dadosGrafico[$ativo])) {
                    $dadosGrafico[$ativo]['dividendos'] = $item['total_dividendos'];
                }
            }
        } catch (Exception $e) {
            $mensagemErro = "Erro ao carregar relatório: " . $e->getMessage();
        }

        $title = "Relatório | " . APP_NAME;

        require VIEW_PATH . 'relatorio.php';
    }
}
