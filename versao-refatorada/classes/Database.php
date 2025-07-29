<?php

/**
 * Shared PDO connection (Singleton-like).
 * Credentials come from config constants (config/config.php loads .env first).
 */
class Database
{
    /** @var PDO|null */
    private static ?PDO $pdo = null;

    // Prevent instantiation
    private function __construct() {}

    /**
     * Retorna a conexão PDO compartilhada.
     * @return PDO
     * @throws RuntimeException se a conexão falhar.
     */
    public static function getConnection(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        if (!defined('DB_HOST')) {
            throw new RuntimeException('Config não carregada antes de usar Database.');
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            DB_HOST,
            DB_PORT,
            DB_NAME,
            DB_CHARSET
        );

        try {
            self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Falha na conexão com o banco de dados.', 0, $e);
        }

        if (!self::$pdo instanceof PDO) {
            throw new RuntimeException('Database connection failed unexpectedly.');
        }

        return self::$pdo;
    }
}