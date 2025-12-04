<?php

/**
 * App configuration bootstrap.
 * Loads .env key/values, defines global constants, sets error mode,
 * and registers a simple autoloader for flat classes.
 *
 * Localização: versao-refatorada/config/config.php
 * Incluir no topo de entrypoints públicos (index.php, etc.):
 *   require __DIR__ . '/config/config.php';
 */

define('BASE_URL', '/');


if (!defined('APP_CONFIG_LOADED')) {
    define('APP_CONFIG_LOADED', true);

    // ------------------------------------------------------------------
    // Caminhos base
    // ------------------------------------------------------------------
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
    define('CONFIG_PATH', __DIR__ . DIRECTORY_SEPARATOR);
    define('CLASS_PATH', BASE_PATH . 'classes' . DIRECTORY_SEPARATOR);
    define('VIEW_PATH',  BASE_PATH . 'views' . DIRECTORY_SEPARATOR);
    define('ASSET_PATH', BASE_PATH . 'assets' . DIRECTORY_SEPARATOR);
    define('ASSET_URL', BASE_URL . 'assets/');

    // ------------------------------------------------------------------
    // Função para carregar .env (chave=valor) em $_ENV/$_SERVER
    // ------------------------------------------------------------------
    /**
     * Carrega variáveis de ambiente de um arquivo .env
     * 
     * @param string $file Caminho completo para o arquivo .env
     * @return void
     * @throws RuntimeException Se o arquivo não for legível
     */
    function app_load_env(string $file): void
    {
        if (!is_readable($file)) {
            throw new RuntimeException("Arquivo .env não encontrado ou não legível: " . $file);
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
            $key = trim($key);
            $value = trim($value);

            if (str_contains($value, ' ')) {
                $value = trim($value, '\'"');
            }

            if (str_contains($value, ' #') || str_contains($value, ' //')) {
                $value = preg_split('/\s[#\/\/]/', $value)[0];
                $value = trim($value);
            }

            if ($key !== '') {
                $_ENV[$key] = $value;
                $_SERVER[$key] = $_ENV[$key];
            }
        }
    }

    // Carrega .env com tratamento de erro
    try {
        app_load_env(CONFIG_PATH . '.env');
    } catch (RuntimeException $e) {
        if (defined('DEBUG') && DEBUG) {
            die("Erro ao carregar configuração: " . $e->getMessage());
        }
        die("Erro de configuração. Por favor contate o administrador.");
    }

    // ------------------------------------------------------------------
    // Função helper para ler env com fallback
    // ------------------------------------------------------------------
    function env(string $key, $default = null)
    {
        return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
    }

    // ------------------------------------------------------------------
    // Constantes de Aplicação
    // ------------------------------------------------------------------
    define('APP_NAME', env('APP_NAME', 'Gestão de Ativos'));
    define('DEFAULT_TITLE', APP_NAME . ' | Sistema de Controle');
    define('APP_ENV', env('APP_ENV', 'development'));

    // Configuração de DEBUG
    $debugFlag = env('DEBUG', null);
    if ($debugFlag === null) {
        $debugFlag = (APP_ENV === 'development');
    } else {
        $debugFlag = filter_var($debugFlag, FILTER_VALIDATE_BOOLEAN);
    }
    define('DEBUG', $debugFlag);

    // ------------------------------------------------------------------
    // Constantes de Banco de Dados
    // ------------------------------------------------------------------
    define('DB_HOST',    env('DB_HOST', '127.0.0.1'));
    define('DB_PORT',    env('DB_PORT', '3306'));
    define('DB_NAME',    env('DB_NAME', 'bolsa_de_valores'));
    define('DB_USER',    env('DB_USER', 'root'));
    define('DB_PASS',    env('DB_PASS', ''));
    define('DB_CHARSET', env('DB_CHARSET', 'utf8mb4'));

    // ------------------------------------------------------------------
    // APIs externas
    // ------------------------------------------------------------------
    define('NEWS_API_KEY', env('NEWS_API_KEY', 'changeme'));
    define('AWESOME_API_BASE', env('AWESOME_API_BASE', 'https://economia.awesomeapi.com.br/json'));

    // ------------------------------------------------------------------
    // Configuração de exibição de erros
    // ------------------------------------------------------------------
    if (DEBUG) {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        ini_set('log_errors', '1');
        ini_set('error_log', BASE_PATH . 'logs/php_errors.log');
    } else {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        ini_set('display_errors', '0');
        ini_set('log_errors', '1');
        ini_set('error_log', BASE_PATH . 'logs/php_errors.log');
    }

    // ------------------------------------------------------------------
    // Autoloader simples para classes planas
    // ------------------------------------------------------------------
    spl_autoload_register(function ($class) {
        $file = CLASS_PATH . $class . '.php';
        if (is_readable($file)) {
            require $file;
        }
    });

    // ------------------------------------------------------------------
    // Cria diretório de logs se não existir
    // ------------------------------------------------------------------
    if (!is_dir(BASE_PATH . 'logs')) {
        mkdir(BASE_PATH . 'logs', 0755, true);
    }
}
