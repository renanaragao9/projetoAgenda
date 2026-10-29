<?php

namespace App;

use PDO;

/**
 * Repositório de contatos: encapsula todo o acesso ao banco (CRUD).
 * Recebe uma conexão PDO por injeção, o que permite testar com
 * SQLite em memória sem depender do MySQL.
 */
class ContactRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Cria um contato e retorna o ID gerado.
     */
    public function create(string $name, string $phone, ?string $observations = null): int
    {
        $query = "INSERT INTO contacts (name, phone, observations) VALUES (:name, :phone, :observations)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":phone", $phone);
        $stmt->bindValue(":observations", $observations);
        $stmt->execute();

        return (int) $this->conn->lastInsertId();
    }

    /**
     * Retorna um contato pelo ID, ou null se não existir.
     */
    public function find(int $id): ?array
    {
        $query = "SELECT * FROM contacts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);

        return $contact === false ? null : $contact;
    }

    /**
     * Retorna todos os contatos.
     */
    public function all(): array
    {
        $stmt = $this->conn->query("SELECT * FROM contacts ORDER BY id");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza um contato existente. Retorna true se alguma linha foi afetada.
     */
    public function update(int $id, string $name, string $phone, ?string $observations = null): bool
    {
        $query = "UPDATE contacts SET name = :name, phone = :phone, observations = :observations WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":phone", $phone);
        $stmt->bindValue(":observations", $observations);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Remove um contato. Retorna true se alguma linha foi removida.
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM contacts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
