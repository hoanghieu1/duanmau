<?php

class Product extends BaseModel
{
    // ADMIN/CLIENT: lấy tất cả sản phẩm
    public function getAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ADMIN/CLIENT: lấy 1 sản phẩm theo id
    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // CLIENT: top 4 mới nhất
    public function top4Lastest()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 4");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // CLIENT: top 4 view cao nhất
    public function top4View()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products ORDER BY view_count DESC LIMIT 4");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // CLIENT: cập nhật view_count
    public function updateViewCount($id, $view_count)
    {
        $stmt = $this->pdo->prepare("UPDATE products SET view_count = ? WHERE id = ?");
        return $stmt->execute([$view_count, $id]);
    }

    // CLIENT: lọc theo danh mục
    public function getByCategory($cateId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY id DESC");
        $stmt->execute([$cateId]);
        return $stmt->fetchAll();
    }

    // ADMIN: thêm mới sản phẩm
    public function insert($data)
    {
        $sql = "INSERT INTO products (category_id, name, description, price, quantity, image)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['quantity'],
            $data['image']
        ]);
    }

    // ADMIN: cập nhật sản phẩm (có/không có ảnh)
    public function update($id, $data)
    {
        if (isset($data['image'])) {
            $sql = "UPDATE products
                    SET category_id=?, name=?, description=?, price=?, quantity=?, image=?
                    WHERE id=?";
            $params = [
                $data['category_id'],
                $data['name'],
                $data['description'],
                $data['price'],
                $data['quantity'],
                $data['image'],
                $id
            ];
        } else {
            $sql = "UPDATE products
                    SET category_id=?, name=?, description=?, price=?, quantity=?
                    WHERE id=?";
            $params = [
                $data['category_id'],
                $data['name'],
                $data['description'],
                $data['price'],
                $data['quantity'],
                $id
            ];
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // ADMIN: xóa sản phẩm theo id
    public function deleteById($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
