<?php

class productClientController
{
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $title = 'Sản phẩm';
        $view  = 'products';

        // Lấy tất cả danh mục để hiển thị bộ lọc
        $categories = $this->categoryModel->getAll();

        // Nếu có ?category_id thì lọc theo danh mục
        $categoryId = $_GET['category_id'] ?? null;

        if (!empty($categoryId)) {
            $products = $this->productModel->getByCategory($categoryId);
        } else {
            $products = $this->productModel->getAll();
        }

        // Biến này để view biết đang chọn danh mục nào
        $selectedCategoryId = $categoryId;

        require_once PATH_VIEW_CLIENT_MAIN;
    }
}