<?php

if (!defined('APP_CONFIG_LOADED')) {
    require_once __DIR__ . '/../config/config.php';
}

class RelatorioService
{
    private Compra $compra;
    private Dividendo $dividendo;
    private Ativo $ativo;

    public function __construct()
    {
        $this->compra    = new Compra();
        $this->dividendo = new Dividendo();
        $this->ativo     = new Ativo();
    }

    /**
     * Retorna resumo geral de investimentos:
     * - Preço médio de cada ativo
     * - Dividendos totais por ativo
     * - Dividendos totais gerais
     */
    public function getResumoGeral(string $dataInicio = null, string $dataFim = null): array
    {
        // Preço médio por ativo
        $precos = $dataInicio && $dataFim
            ? $this->ativo->calcularPrecoMedioPorPeriodo($dataInicio, $dataFim)
            : $this->ativo->calcularPrecoMedio();

        // Dividendos por ativo
        $dividendos = $dataInicio && $dataFim
            ? $this->dividendo->calcularDividendosPorPeriodo($dataInicio, $dataFim)
            : $this->dividendo->calcularDividendosPorAtivo();

        // Total de dividendos
        $totalDividendos = $dataInicio && $dataFim
            ? $this->dividendo->calcularTotalPeriodo($dataInicio, $dataFim)
            : array_sum(array_column($dividendos, 'total_dividendos'));

        return [
            'precos'          => $precos,
            'dividendos'      => $dividendos,
            'totalDividendos' => $totalDividendos,
        ];
    }

    /**
     * Retorna dados de dividendos prontos para gráfico (labels/values).
     * Útil em Chart.js ou Highcharts.
     */
    public function getGraficoDividendos(string $dataInicio = null, string $dataFim = null): array
    {
        $dividendos = $dataInicio && $dataFim
            ? $this->dividendo->calcularDividendosPorPeriodo($dataInicio, $dataFim)
            : $this->dividendo->calcularDividendosPorAtivo();

        return [
            'labels' => array_column($dividendos, 'ativo'),
            'values' => array_map('floatval', array_column($dividendos, 'total_dividendos')),
        ];
    }

    /**
     * Obtém lista completa de ativos com posição (quantidade, preço médio).
     */
    public function getPosicaoAtivos(string $dataInicio = null, string $dataFim = null): array
    {
        return $dataInicio && $dataFim
            ? $this->ativo->calcularPrecoMedioPorPeriodo($dataInicio, $dataFim)
            : $this->ativo->calcularPrecoMedio();
    }
}