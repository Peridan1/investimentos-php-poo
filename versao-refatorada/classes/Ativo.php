<?php

class Ativo
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Calcula preço médio de todos os ativos.
     * @return array Exemplo: [ ['ativo'=>'PETR4','total_quantidade'=>100,'total_valor'=>2500,'preco_medio'=>25.00], ... ]
     */
    public function calcularPrecoMedio(): array
    {
        $sql = "
            SELECT 
                ativo,
                SUM(quantidade) AS total_quantidade,
                SUM(quantidade * valor_unitario) AS total_valor
            FROM compras
            GROUP BY ativo
        ";

        $stmt = $this->db->query($sql);
        $ativos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($ativos as &$ativo) {
            $quantidade = (int)$ativo['total_quantidade'] ?: 1;
            $ativo['preco_medio'] = $quantidade > 0
                ? round($ativo['total_valor'] / $quantidade, 2)
                : 0;
        }

        return $ativos;
    }

    /**
     * Calcula preço médio de um ativo específico.
     * @return array|false
     */
    public function calcularPrecoMedioPorAtivo(string $ativo): array|false
    {
        $sql = "
            SELECT 
                ativo,
                SUM(quantidade) AS total_quantidade,
                SUM(quantidade * valor_unitario) AS total_valor
            FROM compras
            WHERE ativo = :ativo
            GROUP BY ativo
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':ativo' => $ativo]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $quantidade = (int)$data['total_quantidade'] ?: 1;
            $data['preco_medio'] = $quantidade > 0
                ? round($data['total_valor'] / $quantidade, 2)
                : 0;
        }

        return $data;
    }

    /**
     * Lista todos os ativos únicos.
     */
    public function listarAtivos(): array
    {
        $sql = "SELECT DISTINCT ativo FROM compras ORDER BY ativo";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Calcula preço médio com filtro de período.
     */
    public function calcularPrecoMedioPorPeriodo(string $dataInicio, string $dataFim): array
    {
        $sql = "
            SELECT 
                ativo,
                SUM(quantidade) AS total_quantidade,
                SUM(quantidade * valor_unitario) AS total_valor
            FROM compras
            WHERE data_compra BETWEEN :inicio AND :fim
            GROUP BY ativo
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $dataInicio,
            ':fim'    => $dataFim,
        ]);
        $ativos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($ativos as &$ativo) {
            $quantidade = (int)$ativo['total_quantidade'] ?: 1;
            $ativo['preco_medio'] = $quantidade > 0
                ? round($ativo['total_valor'] / $quantidade, 2)
                : 0;
        }

        return $ativos;
    }
}