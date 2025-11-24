
<?php 
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class Product extends BaseModel
{
    public function getAll() {
        $sql = "SELECT * FROM `products` ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
