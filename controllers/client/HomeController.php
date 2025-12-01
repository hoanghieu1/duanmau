<?php

class HomeController
{
    public function index() 
    {
        // gọi model Product
        $productModel = new Product();


        // lấy 8 sản phẩm mới nhất
        $newProducts = $productModel->getNewProducts();

        $view = 'client/home';
        $title = 'Trang chủ';
        require_once PATH_VIEW_CLIENT . 'main.php';
    }
}