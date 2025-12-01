<?php

class HomeController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function index() 
    {
        $view = 'home';
        $top4Lastest = $this->productModel->top4Lastest();
        $top4View = $this->productModel->top4View();
        $title = 'Trang chủ';
        require_once PATH_VIEW_CLIENT_MAIN;
    }
}