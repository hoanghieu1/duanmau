<?php

class CommentController
{
    private $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }

    // DANH SÁCH BÌNH LUẬN
    public function index()
    {
        $view  = 'comment/index';
        $title = 'Danh sách bình luận';

        $data = $this->commentModel->getAll();

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // ẨN BÌNH LUẬN (status = 0)
    public function hide()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->commentModel->updateStatus($id, 0);
        }

        header('Location: ?mode=admin&action=list-comments');
        exit;
    }

    // HIỆN LẠI BÌNH LUẬN (status = 1)
    public function show()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->commentModel->updateStatus($id, 1);
        }

        header('Location: ?mode=admin&action=list-comments');
        exit;
    }
}
