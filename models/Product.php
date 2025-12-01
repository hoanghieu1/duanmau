
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

    //hàm xóa dữ liệu
    public function delete($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);

    }

    public function top4Lastest() {
        $stmt = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
        $stmt = $this->pdo->prepare($stmt);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateViewCount($view_count, $id) {
        $sql = "UPDATE products SET view_count = :view_count WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':view_count' => $view_count, ':id' => $id]);
    }

    public function top4View() {
        $stmt = "SELECT * FROM products ORDER BY view_count DESC LIMIT 4";
        $stmt = $this->pdo->prepare($stmt);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // hàm lọc sản phẩm theo danh mục
    public function getByCategory($cateId)
    {
        $sql = "SELECT * FROM products WHERE category_id = :cateId ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':cateId' => $cateId]);
        return $stmt->fetchAll();
    }

}
