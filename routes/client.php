<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    // Trang chủ client
    '/'         => (new HomeController)->index(),
    
    // Danh sách sản phẩm theo danh mục
    'products-by-category' => (new ProductController)->listByCategory(),

    // Trang chi tiết sản phẩm
    'product-detail' => (new ProductClientController)->detail(),

    // DEFAULT
    default     => (new HomeController)->index(),
};