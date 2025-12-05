<?php

class CompraController
{
    private Compra $model;

    public function __construct()
    {
        $this->model = new Compra();
    }

    public function index()
    {
        $compras = $this->model->findAll();
        require __DIR__ . '/../views/compras.php';
    }

    public function store()
    {
        $ativo = $_POST['ativo'];
        $quantidade = (int)$_POST['quantidade'];
        $valorUnitario = (float)$_POST['valor_unitario'];
        $dataCompra = $_POST['data_compra'];

        $this->model->adicionar($ativo, $quantidade, $valorUnitario, $dataCompra);

        header('Location: /compras');
        exit;
    }

    public function destroy(int $id)
    {
        $this->model->delete($id);
        header('Location: /compras');
        exit;
    }
}