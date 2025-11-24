<?php
class CommentController
{
    private $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }

    public function index()
    {
        $view = 'comment/index';
        $title = 'Danh sách bình luận';
        $data = $this->commentModel->getAll();
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function create()
    {
        $view = 'comment/form';
        $title = 'Tạo bình luận mới';
        $data = null;
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'] ?? null;
            $product_id = $_POST['product_id'] ?? null;
            $content = $_POST['content'] ?? '';

            $sql = "INSERT INTO comments (user_id, product_id, content) VALUES (:user_id, :product_id, :content)";
            $stmt = $this->commentModel->pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id ?: null,
                ':product_id' => $product_id ?: null,
                ':content' => $content
            ]);
        }
        header('Location: ?mode=admin&action=list-comments');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?mode=admin&action=list-comments');
            exit;
        }
        $stmt = $this->commentModel->pdo->prepare('SELECT * FROM comments WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        $view = 'comment/form';
        $title = 'Chỉnh sửa bình luận';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $user_id = $_POST['user_id'] ?? null;
            $product_id = $_POST['product_id'] ?? null;
            $content = $_POST['content'] ?? '';

            $sql = "UPDATE comments SET user_id = :user_id, product_id = :product_id, content = :content WHERE id = :id";
            $stmt = $this->commentModel->pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id ?: null,
                ':product_id' => $product_id ?: null,
                ':content' => $content,
                ':id' => $id
            ]);
        }
        header('Location: ?mode=admin&action=list-comments');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $this->commentModel->pdo->prepare('DELETE FROM comments WHERE id = ?');
            $stmt->execute([$id]);
        }
        header('Location: ?mode=admin&action=list-comments');
        exit;
    }
}
