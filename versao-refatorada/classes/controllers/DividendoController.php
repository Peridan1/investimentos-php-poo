<?php

class DividendoController
{
    private Dividendo $model;

    public function __construct()
    {
        $this->model = new Dividendo();
    }

    // GET /dividendos
    public function index()
    {
        $dividendos = $this->model->findAll();
        require __DIR__ . '/../views/dividendos.php';
    }

    // GET /dividendos/{id}
    public function show(int $id)
    {
        $dividendo = $this->model->findById($id);
        require __DIR__ . '/../views/editar_dividendo.php';
    }

    // POST /dividendos
    public function store()
    {
        $ativo = $_POST['ativo'];
        $valor = (float)$_POST['valor'];
        $data = $_POST['data_recebimento'];

        $this->model->adicionar($ativo, $valor, $data);

        header('Location: /dividendos');
        exit;
    }

    // POST /dividendos/{id}/update
    public function update(int $id)
    {
        $ativo = $_POST['ativo'];
        $valor = (float)$_POST['valor'];
        $data = $_POST['data_recebimento'];

        $this->model->atualizarDividendo($id, $ativo, $valor, $data);

        header('Location: /dividendos');
        exit;
    }

    // POST /dividendos/{id}/delete
    public function destroy(int $id)
    {
        $this->model->delete($id);
        header('Location: /dividendos');
        exit;
    }
}