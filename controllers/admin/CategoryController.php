<?php
class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $view = 'category/index';
        $title = 'Danh sách danh mục';
        $data = $this->categoryModel->getAll();
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function create()
    {
        $view = 'category/form';
        $title = 'Tạo danh mục mới';
        $data = null;
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public funtion store()
    {
        if ($_SERVER['REQUEST_METHOOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            // validate xíu xíu
            if ($name === '') {
                // quay lại form với thông báo lỗi
                $view = 'category/form';
                $title = 'Tạo danh mục mới';
                $error = 'Tên danh mục không được để trống.';
                require_once PATH_VIEW_ADMIN_MAIN;
                return;
            }
            // lưu vào db
            $sql = "INSERT INTO categories (name, description, category_id) VALUES (:name, :description, :category_id)";
            $stmt = $this->categoryModel->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':category_id' => $category_id ?: null
            ]);
        }

        header('Location: ?mode=admin&action=list-categories');
        exit;

        
    }
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?mode=admin&action=list-categories');
            exit;
        }
        $stmt = $this->categoryModel->pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        $view = 'category/form';
        $title = 'Chỉnh sửa danh mục';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

             if ($name == '') {
            $view = 'category/form';
            $title = 'Chỉnh sửa danh mục';
            $error = "Tên danh mục không được để trống!";

            // Lấy lại dữ liệu đang sửa
            $stmt = $this->categoryModel->pdo->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch();

            require_once PATH_VIEW_ADMIN_MAIN;
            return;
        }
        // Cập nhật vào database
            $sql = "UPDATE categories SET name = :name, description = :description, category_id = :category_id WHERE id = :id";
            $stmt = $this->categoryModel->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':category_id' => $category_id ?: null,
                ':id' => $id
            ]);
        }
        header('Location: ?mode=admin&action=list-categories');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            // Check for child categories referencing this id
            $stmt = $this->categoryModel->pdo->prepare('SELECT COUNT(*) FROM categories WHERE category_id = ?');
            $stmt->execute([$id]);
            $childCount = (int) $stmt->fetchColumn();

            // Check for products referencing this category
            $prodStmt = $this->categoryModel->pdo->prepare('SELECT COUNT(*) FROM products WHERE category_id = ?');
            $prodStmt->execute([$id]);
            $prodCount = (int) $prodStmt->fetchColumn();

            if ($childCount > 0 || $prodCount > 0) {
                // Cannot delete because of FK constraint. Redirect with error code.
                $error = $prodCount > 0 ? 'has_products' : 'has_children';
                header('Location: ?mode=admin&action=list-categories&error=' . $error);
                exit;
            }

            $stmt = $this->categoryModel->pdo->prepare('DELETE FROM categories WHERE id = ?');
            $stmt->execute([$id]);
        }
        header('Location: ?mode=admin&action=list-categories');
        exit;
    }
}
