<?php

namespace Models;

class Urls extends BaseRepository
{
    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->tableName = 'urls';
    }

    public function updateStatById(int $id): bool
    {
        $statement = $this->conn->prepare("UPDATE $this->tableName SET stats=stats + 1 WHERE id=:id");
        $statement->bindValue(":id", $id);

        return $statement->execute();
    }
}