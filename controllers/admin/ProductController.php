<?php
class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function dashboard() {
        $title = 'ĐÂY LÀ TRANG QUẢN TRỊ';
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    
    public function index() {
        $view = 'product/index';    
        $title = 'Danh sách sản phẩm';
        $data = $this->productModel->getAll();
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?mode=admin&action=list-product');
            exit;
        }
        // lấy thông tin sản phẩm
        $stmt = $this->productModel->pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if (!$data) {
        // Không có sản phẩm thì quay lại danh sách
        header('Location: ?mode=admin&action=list-product');
        exit;
        }
        // hiện tên danh mục
        $catModel = new Category();
        $categories = $catModel->getAll();
        
        $view = 'product/show';
        $title = 'Chi tiết sản phẩm';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function create()
    {
        // get categories for select
        $catModel = new Category();
        $categories = $catModel->getAll();

        $view = 'product/form';
        $title = 'Tạo sản phẩm mới';
        $data = null;
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;

            // handle file upload (store in assets/uploads/products/)
            $imageName = '';
            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('prod_') . '.' . $ext;
                $uploadDir = PATH_ASSETS_UPLOADS . 'products/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $targetPath = $uploadDir . $imageName;
                move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
            }

            $sql = "INSERT INTO products (category_id, name, description, price, quantity, image) VALUES (:category_id, :name, :description, :price, :quantity, :image)";
            $stmt = $this->productModel->pdo->prepare($sql);
            $stmt->execute([
                ':category_id' => $category_id ?: null,
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':quantity' => $quantity,
                ':image' => $imageName
            ]);
        }
        header('Location: ?mode=admin&action=list-product');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?mode=admin&action=list-product');
            exit;
        }
        $stmt = $this->productModel->pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        $catModel = new Category();
        $categories = $catModel->getAll();

        $view = 'product/form';
        $title = 'Chỉnh sửa sản phẩm';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;

            // handle file upload
            $imageName = null;
            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('prod_') . '.' . $ext;
                $uploadDir = PATH_ASSETS_UPLOADS . 'products/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $targetPath = $uploadDir . $imageName;
                move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
                // optionally delete old image
                $oldStmt = $this->productModel->pdo->prepare('SELECT image FROM products WHERE id = ?');
                $oldStmt->execute([$id]);
                $old = $oldStmt->fetchColumn();
                if ($old && file_exists($uploadDir . $old)) {
                    @unlink($uploadDir . $old);
                }
            }

            if ($imageName) {
                $sql = "UPDATE products SET category_id = :category_id, name = :name, description = :description, price = :price, quantity = :quantity, image = :image WHERE id = :id";
                $params = [
                    ':category_id' => $category_id ?: null,
                    ':name' => $name,
                    ':description' => $description,
                    ':price' => $price,
                    ':quantity' => $quantity,
                    ':image' => $imageName,
                    ':id' => $id
                ];
            } else {
                $sql = "UPDATE products SET category_id = :category_id, name = :name, description = :description, price = :price, quantity = :quantity WHERE id = :id";
                $params = [
                    ':category_id' => $category_id ?: null,
                    ':name' => $name,
                    ':description' => $description,
                    ':price' => $price,
                    ':quantity' => $quantity,
                    ':id' => $id
                ];
            }
            $stmt = $this->productModel->pdo->prepare($sql);
            $stmt->execute($params);
        }
        header('Location: ?mode=admin&action=list-product');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            //  xóa ảnh
            $uploadDir = PATH_ASSETS_UPLOADS . 'products/';

            $oldStmt = $this->productModel->pdo->prepare('SELECT image FROM products WHERE id = ?');
            $oldStmt->execute([$id]);
            $old = $oldStmt->fetchColumn();

            if ($old && file_exists($uploadDir . $old)) {
                @unlink($uploadDir . $old);
            }

            // xóa bản ghi
            $stmt = $this->productModel->pdo->prepare('DELETE FROM products WHERE id = ?');
            $stmt->execute([$id]);
        }
        header('Location: ?mode=admin&action=list-product');
        exit;
    }
}
?>