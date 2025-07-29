<?php
require_once __DIR__ . '/../classes/Ativo.php';
require_once __DIR__ . '/../classes/Dividendo.php';

function calcularTotalDividendos(): string
{
    $dividendo = new Dividendo();
    $lista = $dividendo->listarDividendos();

    $valor = array_reduce($lista, fn($soma, $item) => $soma + $item['valor'], 0);

    return number_format($valor, 2, ',', '.');
}

function calcularTotalInvestido(): string
{
    $ativo = new Ativo();
    $investimentos = $ativo->calcularPrecoMedio();

    $valor = array_reduce($investimentos, fn($soma, $item) => $soma + $item['total_valor'], 0);

    return number_format($valor, 2, ',', '.');
}

function redirectWithFlash(string $rota, string $tipo, string $mensagem): never
{
    $_SESSION['flash'][$tipo] = $mensagem;
    header('Location: ' . $rota);
    exit;
}

function redirecionar($url)
{
    header("Location: $url");
    exit;
}

function usuarioLogado()
{
    return isset($_SESSION['usuario']);
}