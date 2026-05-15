<?php

class DividendoController
{
    private Dividendo $model;

    public function __construct()
    {
        $this->model = new Dividendo();
    }

    // GET /dividendos
    public function index(): void
    {
        $lista = $this->model->findAll();
        require VIEW_PATH . 'dividendos.php';
    }

    // GET /dividendos/{id}
    public function show(string $id): void
    {
        $dividendo = $this->model->findById((int) $id);
        require VIEW_PATH . 'editar_dividendo.php';
    }

    // POST /dividendos
    public function store(): void
    {
        requireAuth();
        csrf_verify();

        $ativo = trim($_POST['ativo'] ?? '');
        $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
        $data  = $_POST['data_recebimento'] ?? '';

        if ($ativo === '' || $valor === false || $valor <= 0 || !strtotime($data)) {
            $_SESSION['flash']['erro'] = 'Dados inválidos para o dividendo.';
            header('Location: /dividendos');
            exit;
        }

        $this->model->adicionar($ativo, $valor, $data);
        header('Location: /dividendos');
        exit;
    }

    // POST /dividendos/{id}/update
    public function update(string $id): void
    {
        requireAuth();
        csrf_verify();

        $ativo = trim($_POST['ativo'] ?? '');
        $valor = (float)$_POST['valor'];
        $data = $_POST['data_recebimento'];

        $this->model->atualizarDividendo((int) $id, $ativo, $valor, $data);

        header('Location: /dividendos');
        exit;
    }

    // POST /dividendos/{id}/delete
    public function destroy(string $id): void
    {
        requireAuth();
        csrf_verify();

        $this->model->delete((int) $id);
        header('Location: /dividendos');
        exit;
    }
}