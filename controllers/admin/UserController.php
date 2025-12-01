<?php

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Chỉ xem danh sách
    public function index()
    {
        $view  = 'user/index';
        $title = 'Danh sách người dùng';
        $data  = $this->userModel->getAll();
        require_once PATH_VIEW_ADMIN_MAIN;
    }
}
