<?php

// Função helper para renderizar views
function view(string $path, array $data = [])
{
    extract($data); // disponibiliza variáveis dentro da view
    require BASE_PATH . "views/{$path}.php";
}

// ==================== ROTAS ====================

// Dashboard
$router->get('/', function () {
    view('dashboard');
});

$router->get('/dashboard', function () {
    view('dashboard');
});

$router->get('/ativos', 'AtivoController@index');          // lista geral
$router->get('/ativo', 'AtivoController@show');            // relatório com filtro de período
$router->get('/ativos/{ativo}', 'AtivoController@detalhe'); // detalhe de um ativo específico

// Usuários
$router->match(['GET', 'POST'], '/usuarios', function () {
    require_once BASE_PATH . 'classes/Usuario.php';

    session_start();

    $usuarioObj = new Usuario();
    $mensagem = null;
    $tipoMensagem = null;

    // Exclusão
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'], $_POST['id'])) {
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
    view('editar_usuario');
});

// Notícias
$router->match(['GET'], '/noticias', function () {
    require BASE_PATH . 'views/noticias.php';
});


// Relatório
$router->get('/relatorio', function () {
    view('relatorio');
});

// Cotas (sem lógica pesada → deixa na view)
$router->get('/cotas', function () {
    view('cotas');
});


$router->get('/compras/cadastrar', function () {
    view('compras/cadastrar', [
        'mensagem' => $_SESSION['mensagem'] ?? null,
        'title'    => "Cadastrar Compra | " . APP_NAME
    ]);

    unset($_SESSION['mensagem']);
});

$router->post('/compras/cadastrar', function () {
    require_once BASE_PATH . 'classes/Compra.php';

    $compra = new Compra();
    $ok = $compra->adicionarCompra(
        $_POST['ativo'],
        $_POST['quantidade'],
        $_POST['valor_unitario'],
        $_POST['data_compra']
    );

    $_SESSION['mensagem'] = $ok
        ? "Compra cadastrada com sucesso!"
        : "Erro ao cadastrar compra.";

    header("Location: /compras/cadastrar");
    exit;
});

$router->get('/registro', function () {
    require BASE_PATH . 'views/auth/registro.php';
});

$router->get('/login', function () {
    require VIEW_PATH . 'auth/login.php';
});



$router->get('/dividendos', 'DividendoController@index');
$router->get('/dividendos/{id}', 'DividendoController@show');
$router->post('/dividendos', 'DividendoController@store');
$router->post('/dividendos/{id}/update', 'DividendoController@update');
$router->post('/dividendos/{id}/delete', 'DividendoController@destroy');

$router->get('/compras', 'CompraController@index');
$router->post('/compras', 'CompraController@store');
$router->post('/compras/{id}/delete', 'CompraController@destroy');

$router->get('/ativos', 'AtivoController@index');
$router->get('/ativos/{ativo}', 'AtivoController@show');