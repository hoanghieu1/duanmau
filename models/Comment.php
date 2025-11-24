<?php
// Model comments
class Comment extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM `comments` ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
