
<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    // '/'         => (new HomeController)->index(),
    '/'             => (new ProductController)->dashboad(),

    // CRUD PRODUCT
    'list-product'  => (new ProductController)->index(),
    'create-product' => (new ProductController)->create(),
    'store-product' => (new ProductController)->store(),
    'edit-product' => (new ProductController)->edit(),
    'update-product'=> (new ProductController)->update(),
    'delete-product' => (new ProductController)->delete(),
    // lists for other resources
    'list-categories' => (new CategoryController)->index(),
    'create-category' => (new CategoryController)->create(),
    'store-category' => (new CategoryController)->store(),
    'edit-category' => (new CategoryController)->edit(),
    'update-category' => (new CategoryController)->update(),
    'delete-category' => (new CategoryController)->delete(),

    // USERS CRUD
    'list-users' => (new UserController)->index(),
    'create-user' => (new UserController)->create(),
    'store-user' => (new UserController)->store(),
    'edit-user' => (new UserController)->edit(),
    'update-user' => (new UserController)->update(),
    'delete-user' => (new UserController)->delete(),

    // COMMENTS CRUD
    'list-comments' => (new CommentController)->index(),
    'create-comment' => (new CommentController)->create(),
    'store-comment' => (new CommentController)->store(),
    'edit-comment' => (new CommentController)->edit(),
    'update-comment' => (new CommentController)->update(),
    'delete-comment' => (new CommentController)->delete(),
    'delete-product' => '',
    'show-product'  => '', // Hiển thị thông tin chi tiết
    'create-product' => '', // Hiển thị form tạo mới
    'store-product' => '', // Lưu thông tin tạo mới vào CSDL
    'edit-product' => '', // Hiển thị form cập nhật
    'update-product'=> '' // Lưu thông tin cập nhật vào CSDL
};
