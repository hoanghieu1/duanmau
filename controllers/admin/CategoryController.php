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
        $view  = 'category/form';
        $title = 'Tạo danh mục mới';
        $data  = null;

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $data = $this->categoryModel->find($id);
    if (!$data) {
        header('Location: ?mode=admin&action=list-categories&error=not_found');
        exit;
    }

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

        // validate
        if ($name === '') {
            $view = 'category/form';
            $title = 'Chỉnh sửa danh mục';
            $error = "Tên danh mục không được để trống!";

            $data = $this->categoryModel->find($id);
            require_once PATH_VIEW_ADMIN_MAIN;
            return;
        }

        // DB update via Model
        $this->categoryModel->updateById($id, $name, $description, $category_id ?: null);
    }

    header('Location: ?mode=admin&action=list-categories');
    exit;
    }


    public function delete()
    {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $childCount = $this->categoryModel->countChildren($id);
        $prodCount  = $this->categoryModel->countProducts($id);

        if ($childCount > 0 || $prodCount > 0) {
            $error = $prodCount > 0 ? 'has_products' : 'has_children';
            header('Location: ?mode=admin&action=list-categories&error=' . $error);
            exit;
        }

        $this->categoryModel->deleteById($id);
    }

    header('Location: ?mode=admin&action=list-categories');
    exit;
    }

}
