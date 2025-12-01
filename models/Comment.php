<?php

class Comment extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM comments ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE comments SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id'     => $id
        ]);
    }
}
