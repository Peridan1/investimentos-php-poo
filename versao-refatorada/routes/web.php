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

// Preço Médio (Ativo)
$router->get('/ativo', function () {

    require_once BASE_PATH . 'classes/Ativo.php';

    $ativoObj = new Ativo();

    $dataInicio = $_GET['data_inicio'] ?? null;
    $dataFim    = $_GET['data_fim'] ?? null;

    if ($dataInicio && $dataFim) {
        $relatorio = $ativoObj->calcularPrecoMedioPorPeriodo($dataInicio, $dataFim);
    } else {
        $relatorio = $ativoObj->calcularPrecoMedio();
    }

    view('ativo', [
        'relatorio' => $relatorio,
        'title'     => "Preço Médio | " . APP_NAME
    ]);
});

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

// Dividendos
$router->match(['GET', 'POST'], '/dividendos', function () {
    require_once BASE_PATH . 'classes/Dividendo.php';
    require_once BASE_PATH . 'config/config.php';

    $dividendo = new Dividendo();
    $mensagem  = '';
    $resultado = null;

    // Excluir
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'excluir') {
        $resultado = $dividendo->excluirDividendo((int) $_POST['id']);
        $mensagem  = $resultado ? "Dividendo excluído com sucesso!" : "Erro ao excluir dividendo.";
    }

    // Cadastrar
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastrar') {
        $resultado = $dividendo->adicionarDividendo(
            $_POST['ativo'],
            (float)$_POST['valor'],
            $_POST['data_recebimento']
        );
        $mensagem = $resultado ? "Dividendo cadastrado com sucesso!" : "Erro ao cadastrar dividendo.";
    }

    // Filtro GET
    $dataInicio = $_GET['data_inicio'] ?? null;
    $dataFim    = $_GET['data_fim'] ?? null;

    $lista = $dataInicio && $dataFim
        ? $dividendo->listarPorPeriodo($dataInicio, $dataFim)
        : $dividendo->listarDividendos();

    view('dividendos', [
        'title' => "Dividendos | " . APP_NAME,
        'mensagem' => $mensagem,
        'resultado' => $resultado,
        'lista' => $lista,
        'dataInicio' => $dataInicio,
        'dataFim' => $dataFim
    ]);
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

$router->get('/compras', function () {

    require_once BASE_PATH . 'classes/Compra.php';
    $compraObj = new Compra();

    $lista = $compraObj->listarCompras();

    view('compras/listar', [
        'compras' => $lista,
        'title'   => "Listar Compras | " . APP_NAME
    ]);
});

$router->get('/registro', function () {
    require BASE_PATH . 'views/auth/registro.php';
});

$router->get('/login', function () {
    require VIEW_PATH . 'auth/login.php';
});