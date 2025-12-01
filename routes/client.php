<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    // Trang chủ client
    '/'         => (new HomeController)->index(),
    
    // Danh sách sản phẩm theo danh mục
    'products'       => (new ProductClientController)->index(),

    // Trang chi tiết sản phẩm
    'detail-product' => (new DetailProductController)->show(),

    // DEFAULT
    default     => (new HomeController)->index(),
};