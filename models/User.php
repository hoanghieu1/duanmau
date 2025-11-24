<?php
// Model users
class User extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM `users` ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
