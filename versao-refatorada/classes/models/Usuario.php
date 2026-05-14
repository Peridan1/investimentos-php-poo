<?php

class Usuario extends BaseModel
{
    protected string $table = 'usuarios';

    /**
     * Cria um novo usuário.
     */
    public function criarUsuario(string $nome, string $email, string $senha): bool
    {
        try {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO {$this->table} (nome, email, senha)
                VALUES (:nome, :email, :senha)";
            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':nome'  => $nome,
                ':email' => $email,
                ':senha' => $senhaHash,
            ]);
        } catch (PDOException $e) {
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
     */
    public function findByEmail(string $email): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lista todos os usuários (sem senha).
     */
    public function listarUsuarios(): array
    {
        $sql = "SELECT id, nome, email, criado_em FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Exclui usuário por ID.
     */
    public function excluirUsuario(int $id): void
    {
        $this->delete($id);
    }

    /**
     * Busca um usuário por ID (sem senha).
     */
    public function buscarUsuario(int $id): array|false
    {
        $sql = "SELECT id, nome, email FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza nome e email.
     */
    public function atualizarUsuario(int $id, string $nome, string $email): void
    {
        $sql = "UPDATE {$this->table}
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