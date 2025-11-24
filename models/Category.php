<?php
// Model categories
class Category extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM `categories` ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
