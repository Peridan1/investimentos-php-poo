<?php

// Função helper para renderizar views
function view(string $path, array $data = [])
{
    extract($data); // disponibiliza variáveis dentro da view
    require BASE_PATH . "views/{$path}.php";
}

// ==================== ROTAS PÚBLICAS ====================

// Dashboard (público — pode conter dados gerais)
$router->get('/', 'DashboardController@index');
$router->get('/dashboard', 'DashboardController@index');

// Relatório
$router->get('/relatorio', 'RelatorioController@index');

// Notícias
$router->get('/noticias', 'NoticiaController@index');

// Cotas
$router->get('/cotas', 'CotaController@index');

// Ativos (leitura pública)
$router->get('/ativos', 'AtivoController@index');
$router->get('/ativo', 'AtivoController@show');
$router->get('/ativos/{ativo}', 'AtivoController@detalhe');

// ==================== ROTAS PROTEGIDAS ====================

// Usuários
$router->match(['GET', 'POST'], '/usuarios', function () {
    requireAuth();

    $usuarioObj = new Usuario();
    $mensagem = null;
    $tipoMensagem = null;

    // Exclusão
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'], $_POST['id'])) {
        csrf_verify();
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id !== false) {
            $usuarioObj->excluirUsuario($id);
            $mensagem = "Usuário excluído com sucesso!";
            $tipoMensagem = "sucesso";
        } else {
            $mensagem = "ID inválido para exclusão.";
            $tipoMensagem = "erro";
        }
    }

    // Lista
    $usuarios = $usuarioObj->listarUsuarios();

    view('usuarios', [
        'usuarios' => $usuarios,
        'mensagem' => $mensagem,
        'tipo'     => $tipoMensagem,
        'title'    => "Gerenciar Usuários | " . APP_NAME
    ]);
});

$router->get('/usuarios/editar', function () {
    requireAuth();
    view('editar_usuario');
});

// Compras
$router->get('/compras', 'CompraController@index');
$router->post('/compras', 'CompraController@store');
$router->post('/compras/{id}/delete', 'CompraController@destroy');

$router->get('/compras/cadastrar', function () {
    requireAuth();
    view('compras/cadastrar', [
        'mensagem' => $_SESSION['mensagem'] ?? null,
        'title'    => "Cadastrar Compra | " . APP_NAME
    ]);
    unset($_SESSION['mensagem']);
});

$router->post('/compras/cadastrar', function () {
    requireAuth();
    csrf_verify();

    $compra = new Compra();
    $ok = $compra->adicionar(
        trim($_POST['ativo'] ?? ''),
        (int) $_POST['quantidade'],
        (float) $_POST['valor_unitario'],
        $_POST['data_compra']
    );

    $_SESSION['mensagem'] = $ok
        ? "Compra cadastrada com sucesso!"
        : "Erro ao cadastrar compra.";

    header("Location: /compras/cadastrar");
    exit;
});

// Dividendos
$router->get('/dividendos', 'DividendoController@index');
$router->get('/dividendos/{id}', 'DividendoController@show');
$router->post('/dividendos', 'DividendoController@store');
$router->post('/dividendos/{id}/update', 'DividendoController@update');
$router->post('/dividendos/{id}/delete', 'DividendoController@destroy');