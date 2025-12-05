<?php

class Usuario
{
    private PDO $db;

    public function __construct()
    {
        // Usa nosso Singleton centralizado
        $this->db = Database::getConnection();
    }

    /**
     * Cria um novo usuário.
     */
    public function criarUsuario(string $nome, string $email, string $senha): bool
    {
        try {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nome, email, senha)
                VALUES (:nome, :email, :senha)";
            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':nome'  => $nome,
                ':email' => $email,
                ':senha' => $senhaHash,
            ]);
        } catch (PDOException $e) {
            // Log do erro se necessário
            return false;
        }
    }
    /**
     * Valida login por email/senha.
     * @return array|false Dados do usuário (sem senha) ou false.
     */
    public function validarLogin(string $email, string $senha): array|false
    {
        $usuario = $this->findByEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            unset($usuario['senha']);
            return $usuario;
        }
        return false;
    }

    /**
     * Busca usuário por email.
     * @return array|false
     */
    public function findByEmail(string $email): array|false
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Lista todos os usuários.
     */
    public function listarUsuarios(): array
    {
        $sql = "SELECT id, nome, email, criado_em FROM usuarios";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Exclui usuário por ID.
     */
    public function excluirUsuario(int $id): void
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /**
     * Busca um usuário por ID.
     * @return array|false
     */
    public function buscarUsuario(int $id): array|false
    {
        $sql = "SELECT id, nome, email FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Atualiza nome e email.
     */
    public function atualizarUsuario(int $id, string $nome, string $email): void
    {
        $sql = "UPDATE usuarios
                SET nome = :nome, email = :email
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome'  => $nome,
            ':email' => $email,
            ':id'    => $id
        ]);
    }
}