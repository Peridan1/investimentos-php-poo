<?php

class AtivoController
{
    private Ativo $model;

    public function __construct()
    {
        $this->model = new Ativo();
    }

    /**
     * Lista geral de ativos (sem filtro)
     * GET /ativos
     */
    public function index()
    {
        $ativos = $this->model->calcularPrecoMedio();
        require __DIR__ . '/../views/ativos.php';
    }

    /**
     * Relatório detalhado de ativos com filtro opcional de período
     * GET /ativo?data_inicio=YYYY-MM-DD&data_fim=YYYY-MM-DD
     */
    public function show()
    {
        $dataInicio = $_GET['data_inicio'] ?? null;
        $dataFim    = $_GET['data_fim'] ?? null;

        if ($dataInicio && $dataFim) {
            $relatorio = $this->model->calcularPrecoMedioPorPeriodo($dataInicio, $dataFim);
        } else {
            $relatorio = $this->model->calcularPrecoMedio();
        }

        require __DIR__ . '/../views/ativo.php';
    }

    /**
     * Detalhes de um ativo específico
     * GET /ativos/{ativo}
     */
    public function detalhe(string $ativo)
    {
        $detalhes = $this->model->calcularPrecoMedioPorAtivo($ativo);
        require __DIR__ . '/../views/ativo.php';
    }
}