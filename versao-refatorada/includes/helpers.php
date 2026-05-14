<?php

// ------------------------------------------------------------------
// Segurança: CSRF Token
// ------------------------------------------------------------------

/**
 * Retorna o token CSRF da sessão atual (cria um novo se não existir).
 */
function csrf_token(): string
{
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

/**
 * Retorna um campo hidden HTML com o token CSRF.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="_csrf_token" value="' . csrf_token() . '">';
}

/**
 * Valida o token CSRF enviado via POST.
 * Aborta a requisição com 403 se o token for inválido.
 */
function csrf_verify(): void
{
    $token = $_POST['_csrf_token'] ?? '';
    if (!hash_equals($_SESSION['_csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Requisição inválida (CSRF).');
    }
}

// ------------------------------------------------------------------
// Autenticação
// ------------------------------------------------------------------

/**
 * Exige que o usuário esteja logado.
 * Redireciona para /login se não estiver autenticado.
 */
function requireAuth(): void
{
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['flash']['erro'] = 'Você precisa estar logado para acessar essa página.';
        header('Location: /login');
        exit;
    }
}

/**
 * Verifica se o usuário está logado (sem redirecionar).
 */
function usuarioLogado(): bool
{
    return isset($_SESSION['usuario']);
}

// ------------------------------------------------------------------
// Helpers de Navegação
// ------------------------------------------------------------------

/**
 * Redireciona com mensagem flash na sessão.
 */
function redirectWithFlash(string $rota, string $tipo, string $mensagem): never
{
    $_SESSION['flash'][$tipo] = $mensagem;
    header('Location: ' . $rota);
    exit;
}

/**
 * Redireciona para uma URL.
 */
function redirecionar(string $url): never
{
    header("Location: $url");
    exit;
}

// ------------------------------------------------------------------
// Helpers de Cálculo (usados pelo Dashboard)
// ------------------------------------------------------------------

/**
 * Retorna o total de dividendos formatado em BRL.
 */
function calcularTotalDividendos(): string
{
    $dividendo = new Dividendo();
    $lista = $dividendo->findAll();

    $valor = array_reduce($lista, fn($soma, $item) => $soma + $item['valor'], 0);

    return number_format($valor, 2, ',', '.');
}

/**
 * Retorna o total investido formatado em BRL.
 */
function calcularTotalInvestido(): string
{
    $ativo = new Ativo();
    $investimentos = $ativo->calcularPrecoMedio();

    $valor = array_reduce($investimentos, fn($soma, $item) => $soma + $item['total_valor'], 0);

    return number_format($valor, 2, ',', '.');
}