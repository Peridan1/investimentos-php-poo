<?php

class Compra extends BaseModel
{
    protected string $table = 'compras';

    public function adicionar(string $ativo, int $quantidade, float $valorUnitario, string $dataCompra): bool
    {
        $sql = "INSERT INTO {$this->table} (ativo, quantidade, valor_unitario, data_compra)
                VALUES (:ativo, :quantidade, :valor_unitario, :data_compra)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':ativo' => $ativo,
            ':quantidade' => $quantidade,
            ':valor_unitario' => $valorUnitario,
            ':data_compra' => $dataCompra,
        ]);
    }
}