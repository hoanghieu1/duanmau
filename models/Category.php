<?php
class Category extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM categories ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function insert($name, $description, $category_id)
    {
        $sql = "INSERT INTO categories (name, description, category_id) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description, $category_id]);
    }

    public function updateById($id, $name, $description, $category_id)
    {
        $sql = "UPDATE categories SET name = ?, description = ?, category_id = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description, $category_id, $id]);
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function countChildren($id)
    {
        $sql = "SELECT COUNT(*) FROM categories WHERE category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn();
    }

    public function countProducts($id)
    {
        $sql = "SELECT COUNT(*) FROM products WHERE category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn();
    }
}
