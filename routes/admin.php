
<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    // Dashboard

    // '/'         => (new HomeController)->index(),
    '/'             => (new ProductController)->dashboad(),

    // CRUD PRODUCT
    'list-product'  => (new ProductController)->index(),
    'show-product'  => (new ProductController)->show(),
    'create-product' => (new ProductController)->create(),
    'store-product' => (new ProductController)->store(),
    'edit-product' => (new ProductController)->edit(),
    'update-product'=> (new ProductController)->update(),
    'delete-product' => (new ProductController)->delete(),
    // CATEGORIES CRUD
    'list-categories' => (new CategoryController)->index(),
    'create-category' => (new CategoryController)->create(),
    'store-category' => (new CategoryController)->store(),
    'edit-category' => (new CategoryController)->edit(),
    'update-category' => (new CategoryController)->update(),
    'delete-category' => (new CategoryController)->delete(),

    // USERS CRUD
    'list-users' => (new UserController)->index(),

    // COMMENTS CRUD
    'list-comments'     => (new CommentController)->index(),
    'hide-comment'      => (new CommentController)->hide(),   // set status = 0
    'show-comment'      => (new CommentController)->show(),   // set status = 1

    
    // DEFAULT
    default        => (new ProductController)->dashboard(),
};
