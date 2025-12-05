<?php

class Dividendo extends BaseModel
{
    protected string $table = 'dividendos';

    /**
     * Insere novo dividendo.
     */
    public function adicionar(string $ativo, float $valor, string $dataRecebimento): bool
    {
        $sql = "INSERT INTO {$this->table} (ativo, valor, data_recebimento)
                VALUES (:ativo, :valor, :data_recebimento)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':ativo' => $ativo,
            ':valor' => $valor,
            ':data_recebimento' => $dataRecebimento,
        ]);
    }

    /**
     * Atualiza um dividendo existente.
     */
    public function atualizarDividendo(int $id, string $ativo, float $valor, string $dataRecebimento): bool
    {
        $sql = "UPDATE {$this->table}
                SET ativo = :ativo,
                    valor = :valor,
                    data_recebimento = :data_recebimento
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':ativo' => $ativo,
            ':valor' => $valor,
            ':data_recebimento' => $dataRecebimento,
            ':id' => $id,
        ]);
    }

    /**
     * Calcula total de dividendos por ativo.
     */
    public function calcularPorAtivo(): array
    {
        $sql = "SELECT ativo, SUM(valor) AS total_dividendos
                FROM {$this->table}
                GROUP BY ativo";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lista dividendos por período.
     */
    public function listarPorPeriodo(string $dataInicio, string $dataFim): array
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE data_recebimento BETWEEN :inicio AND :fim
                ORDER BY data_recebimento ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $dataInicio,
            ':fim'    => $dataFim,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Calcula total de dividendos por ativo em um período.
     */
    public function calcularPorPeriodo(string $dataInicio, string $dataFim): array
    {
        $sql = "SELECT ativo, SUM(valor) AS total_dividendos
                FROM {$this->table}
                WHERE data_recebimento BETWEEN :inicio AND :fim
                GROUP BY ativo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $dataInicio,
            ':fim'    => $dataFim,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Calcula total geral de dividendos em um período.
     */
    public function calcularTotalPeriodo(string $dataInicio, string $dataFim): float
    {
        $sql = "SELECT SUM(valor) AS total
                FROM {$this->table}
                WHERE data_recebimento BETWEEN :inicio AND :fim";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $dataInicio,
            ':fim'    => $dataFim,
        ]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float)($resultado['total'] ?? 0);
    }
}