<?php

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function dashboard()
    {
        $title = 'ĐÂY LÀ TRANG QUẢN TRỊ';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // LIST
    public function index()
    {
        $view  = 'product/index';
        $title = 'Danh sách sản phẩm';
        $data  = $this->productModel->getAll();

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // SHOW (chi tiết)
    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?mode=admin&action=list-product');
            exit;
        }

        // DB: lấy sản phẩm (đúng MVC: gọi model)
        $data = $this->productModel->find($id);
        if (!$data) {
            header('Location: ?mode=admin&action=list-product');
            exit;
        }

        // DB: lấy danh mục để hiển thị tên/đối chiếu
        $catModel   = new Category();
        $categories = $catModel->getAll();

        $view  = 'product/show';
        $title = 'Chi tiết sản phẩm';

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // FORM CREATE
    public function create()
    {
        $catModel   = new Category();
        $categories = $catModel->getAll();

        $view  = 'product/form';
        $title = 'Tạo sản phẩm mới';
        $data  = null;

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // STORE
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name        = $_POST['name'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $description = $_POST['description'] ?? '';
            $price       = $_POST['price'] ?? 0;
            $quantity    = $_POST['quantity'] ?? 0;

            // validate tối giản
            if ($name === '') {
                $catModel   = new Category();
                $categories = $catModel->getAll();

                $view  = 'product/form';
                $title = 'Tạo sản phẩm mới';
                $error = 'Tên sản phẩm không được để trống!';
                $data  = [
                    'name' => $name,
                    'category_id' => $category_id,
                    'description' => $description,
                    'price' => $price,
                    'quantity' => $quantity,
                    'image' => ''
                ];

                require_once PATH_VIEW_ADMIN_MAIN;
                return;
            }

            // LOGIC: upload ảnh (Controller xử lý nghiệp vụ)
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

            // DB: insert thông qua Model
            $this->productModel->insert([
                'category_id' => $category_id ?: null,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $imageName
            ]);
        }

        header('Location: ?mode=admin&action=list-product');
        exit;
    }

    // FORM EDIT
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?mode=admin&action=list-product');
            exit;
        }

        // DB: lấy sản phẩm cần sửa
        $data = $this->productModel->find($id);
        if (!$data) {
            header('Location: ?mode=admin&action=list-product');
            exit;
        }

        // DB: lấy categories để đổ select
        $catModel   = new Category();
        $categories = $catModel->getAll();

        $view  = 'product/form';
        $title = 'Chỉnh sửa sản phẩm';

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // UPDATE
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = $_POST['id'] ?? null;
            $name        = $_POST['name'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $description = $_POST['description'] ?? '';
            $price       = $_POST['price'] ?? 0;
            $quantity    = $_POST['quantity'] ?? 0;

            if (!$id) {
                header('Location: ?mode=admin&action=list-product');
                exit;
            }

            // validate tối giản
            if ($name === '') {
                $catModel   = new Category();
                $categories = $catModel->getAll();

                $view  = 'product/form';
                $title = 'Chỉnh sửa sản phẩm';
                $error = 'Tên sản phẩm không được để trống!';

                // lấy lại data từ DB để đổ form
                $data = $this->productModel->find($id);

                require_once PATH_VIEW_ADMIN_MAIN;
                return;
            }

            $payload = [
                'category_id' => $category_id ?: null,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'quantity' => $quantity,
            ];

            // LOGIC: nếu có upload ảnh mới
            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('prod_') . '.' . $ext;

                $uploadDir = PATH_ASSETS_UPLOADS . 'products/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $targetPath = $uploadDir . $imageName;
                move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);

                // xóa ảnh cũ
                $old = $this->productModel->find($id);
                if (!empty($old['image']) && file_exists($uploadDir . $old['image'])) {
                    @unlink($uploadDir . $old['image']);
                }

                $payload['image'] = $imageName; // báo cho model update cả image
            }

            // DB: update thông qua Model
            $this->productModel->update($id, $payload);
        }

        header('Location: ?mode=admin&action=list-product');
        exit;
    }

    // DELETE
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $uploadDir = PATH_ASSETS_UPLOADS . 'products/';

            // lấy sản phẩm để biết ảnh cũ
            $old = $this->productModel->find($id);
            if ($old && !empty($old['image']) && file_exists($uploadDir . $old['image'])) {
                @unlink($uploadDir . $old['image']);
            }

            // DB: xóa thông qua Model
            $this->productModel->deleteById($id);
        }

        header('Location: ?mode=admin&action=list-product');
        exit;
    }
}
