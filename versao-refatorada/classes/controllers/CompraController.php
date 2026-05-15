<?php

class CompraController
{
    private Compra $model;

    public function __construct()
    {
        $this->model = new Compra();
    }

    // GET /compras
    public function index(): void
    {
        $compras = $this->model->findAll();
        require VIEW_PATH . 'compras.php';
    }

    // POST /compras
    public function store(): void
    {
        requireAuth();
        csrf_verify();

        $ativo = trim($_POST['ativo'] ?? '');
        $quantidade = (int)$_POST['quantidade'];
        $valorUnitario = (float)$_POST['valor_unitario'];
        $dataCompra = $_POST['data_compra'];

        $this->model->adicionar($ativo, $quantidade, $valorUnitario, $dataCompra);

        header('Location: /compras');
        exit;
    }

    // POST /compras/{id}/delete
    public function destroy(string $id): void
    {
        requireAuth();
        csrf_verify();

        $this->model->delete((int) $id);
        header('Location: /compras');
        exit;
    }
}