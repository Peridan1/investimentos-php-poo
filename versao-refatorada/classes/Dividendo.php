<?php

class Dividendo
{
    private PDO $db;

    public function __construct()
    {
        // Singleton centralizado (Database.php já usa config/.env)
        $this->db = Database::getConnection();
    }

    /**
     * Insere novo dividendo.
     */
    public function adicionarDividendo(string $ativo, float $valor, string $dataRecebimento): bool
    {
        $sql = "INSERT INTO dividendos (ativo, valor, data_recebimento)
                VALUES (:ativo, :valor, :data_recebimento)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':ativo'            => $ativo,
            ':valor'            => $valor,
            ':data_recebimento' => $dataRecebimento,
        ]);
    }

    /**
     * Lista todos os dividendos.
     * @return array
     */
    public function listarDividendos(): array
    {
        $sql = "SELECT id, ativo, valor, data_recebimento FROM dividendos";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Busca dividendo por ID.
     * @return array|false
     */
    public function buscarPorId(int $id): array|false
    {
        $sql = "SELECT * FROM dividendos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Lista dividendos de um ativo específico.
     * @return array
     */
    public function buscarPorAtivo(string $ativo): array
    {
        $sql = "SELECT * FROM dividendos WHERE ativo = :ativo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':ativo' => $ativo]);
        return $stmt->fetchAll();
    }

    /**
     * Soma total de dividendos por ativo (tabela agregada).
     * @return array  ex.: [ ['ativo'=>'PETR4','total_dividendos'=>123.45], ... ]
     */
    public function calcularDividendosPorAtivo(): array
    {
        $sql = "SELECT ativo, SUM(valor) AS total_dividendos
                FROM dividendos
                GROUP BY ativo";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Remove um dividendo pelo ID.
     */
    public function excluirDividendo(int $id): bool
    {
        $sql = "DELETE FROM dividendos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Atualiza um dividendo existente.
     * Útil se corrigir data ou valor.
     */
    public function atualizarDividendo(int $id, string $ativo, float $valor, string $dataRecebimento): bool
    {
        $sql = "UPDATE dividendos
                SET ativo = :ativo,
                    valor = :valor,
                    data_recebimento = :data_recebimento
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':ativo'            => $ativo,
            ':valor'            => $valor,
            ':data_recebimento' => $dataRecebimento,
            ':id'               => $id,
        ]);
    }

    /**
     * Lista todos os dividendos em um intervalo de datas.
     * @return array
     */
    public function listarPorPeriodo(string $dataInicio, string $dataFim): array
    {
        $sql = "SELECT * FROM dividendos 
            WHERE data_recebimento BETWEEN :inicio AND :fim
            ORDER BY data_recebimento ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $dataInicio,
            ':fim'    => $dataFim,
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Calcula o total de dividendos agrupado por ativo dentro de um período.
     * @return array Exemplo: [ ['ativo'=>'PETR4','total_dividendos'=>250], ... ]
     */
    public function calcularDividendosPorPeriodo(string $dataInicio, string $dataFim): array
    {
        $sql = "SELECT ativo, SUM(valor) AS total_dividendos
            FROM dividendos
            WHERE data_recebimento BETWEEN :inicio AND :fim
            GROUP BY ativo";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $dataInicio,
            ':fim'    => $dataFim,
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Calcula o total geral de dividendos em um período.
     */
    public function calcularTotalPeriodo(string $dataInicio, string $dataFim): float
    {
        $sql = "SELECT SUM(valor) AS total
            FROM dividendos
            WHERE data_recebimento BETWEEN :inicio AND :fim";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $dataInicio,
            ':fim'    => $dataFim,
        ]);
        $resultado = $stmt->fetch();
        return (float)($resultado['total'] ?? 0);
    }
}