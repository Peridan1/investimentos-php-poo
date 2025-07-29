<?php

class Compra
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Adiciona uma nova compra.
     */
    public function adicionarCompra(string $ativo, int $quantidade, float $valorUnitario, string $dataCompra): bool
    {
        $sql = "INSERT INTO compras (ativo, quantidade, valor_unitario, data_compra)
                VALUES (:ativo, :quantidade, :valor_unitario, :data_compra)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':ativo'          => $ativo,
            ':quantidade'     => $quantidade,
            ':valor_unitario' => $valorUnitario,
            ':data_compra'    => $dataCompra
        ]);
    }

    /**
     * Lista todas as compras.
     * @return array
     */
    public function listarCompras(): array
    {
        $sql = "SELECT id, ativo, quantidade, valor_unitario, data_compra FROM compras";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Busca uma compra pelo ID.
     * @return array|false
     */
    public function buscarPorId(int $id): array|false
    {
        $sql = "SELECT * FROM compras WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Busca todas as compras de um ativo específico.
     * @return array
     */
    public function buscarPorAtivo(string $ativo): array
    {
        $sql = "SELECT * FROM compras WHERE ativo = :ativo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':ativo' => $ativo]);
        return $stmt->fetchAll();
    }

    /**
     * Remove uma compra pelo ID.
     */
    public function excluirCompra(int $id): bool
    {
        $sql = "DELETE FROM compras WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}