<?php

namespace Models;

use PDO;
use PDOStatement;

class BaseRepository
{
    protected string $tableName = '';
    public function __construct(
        protected PDO $conn
    ) {}

    public function create(array $data): bool
    {
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_map(function($key) {return ":$key";}, array_keys($data)));

        $statement = $this->conn->prepare("INSERT INTO TABLE $this->tableName ($columns) VALUES ($values)");
        $this->bindValues($statement, $data);

        return $statement->execute();
    }

    public function readByCondition(array $conditions): array
    {
        $cond = $this->setConditions($conditions);
        $statement = $this->conn->prepare("SELECT * FROM urls WHERE $cond");
        $this->bindValues($statement, $conditions);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateById(int $id, array $data): bool
    {
        $set = implode(", ", array_map(function($key) {return "$key=:$key";}, array_keys($data)));
        $statement = $this->conn->prepare("UPDATE $this->tableName SET $set WHERE id=:id");
        $statement->bindValue(":id", $id);
        $this->bindValues($statement, $data);

        return $statement->execute();
    }

    public function deleteById(int $id): bool
    {
        $statement = $this->conn->prepare("DELETE FROM $this->tableName WHERE id=:id");
        $statement->bindValue(":id", $id);

        return $statement->execute();
    }

    protected function bindValues(PDOStatement $stmnt, array $data): void
    {
        foreach ($data as $key => $value) {
            $stmnt->bindValue(":$key", $value);
        }
    }

    protected function setConditions(array $conditions): string
    {
        return implode(" AND ", array_map(function($key) {return "$key=:$key";}, array_keys($conditions)));
    }
}