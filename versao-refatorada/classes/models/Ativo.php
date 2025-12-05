<?php

class Ativo extends BaseModel
{
    // usa tabela compras para calcular ativos
    protected string $table = 'compras';

    /**
     * Calcula preço médio de todos os ativos.
     */
    public function calcularPrecoMedio(): array
    {
        $sql = "
            SELECT 
                ativo,
                SUM(quantidade) AS total_quantidade,
                SUM(quantidade * valor_unitario) AS total_valor
            FROM {$this->table}
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
     */
    public function calcularPrecoMedioPorAtivo(string $ativo): array|false
    {
        $sql = "
            SELECT 
                ativo,
                SUM(quantidade) AS total_quantidade,
                SUM(quantidade * valor_unitario) AS total_valor
            FROM {$this->table}
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

        return $data ?: false;
    }

    /**
     * Calcula preço médio de ativos em um período.
     */
    public function calcularPrecoMedioPorPeriodo(string $dataInicio, string $dataFim): array
    {
        $sql = "
            SELECT 
                ativo,
                SUM(quantidade) AS total_quantidade,
                SUM(quantidade * valor_unitario) AS total_valor
            FROM {$this->table}
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
