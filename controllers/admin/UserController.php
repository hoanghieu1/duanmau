<?php
class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $view = 'user/index';
        $title = 'Danh sách người dùng';
        $data = $this->userModel->getAll();
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function create()
    {
        $view = 'user/form';
        $title = 'Tạo người dùng mới';
        $data = null;
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Build dynamic insert based on actual table columns
            $colsInfo = $this->userModel->pdo->query("SHOW COLUMNS FROM users")->fetchAll(PDO::FETCH_ASSOC);
            $insertCols = [];
            $placeholders = [];
            $params = [];
            foreach ($colsInfo as $col) {
                $field = $col['Field'];
                if ($field === 'id') continue;
                if ($field === 'password') {
                    if (!empty($_POST['password'])) {
                        $insertCols[] = $field;
                        $placeholders[] = ':' . $field;
                        $params[':' . $field] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    }
                } elseif (isset($_POST[$field])) {
                    $insertCols[] = $field;
                    $placeholders[] = ':' . $field;
                    $params[':' . $field] = $_POST[$field];
                }
            }
            if (!empty($insertCols)) {
                $sql = 'INSERT INTO users (' . implode(',', $insertCols) . ') VALUES (' . implode(',', $placeholders) . ')';
                $stmt = $this->userModel->pdo->prepare($sql);
                $stmt->execute($params);
            }
        }
        header('Location: ?mode=admin&action=list-users');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?mode=admin&action=list-users');
            exit;
        }
        $stmt = $this->userModel->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        $view = 'user/form';
        $title = 'Chỉnh sửa người dùng';
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) return header('Location: ?mode=admin&action=list-users');

            // Build dynamic update based on submitted fields and actual table columns
            $colsInfo = $this->userModel->pdo->query("SHOW COLUMNS FROM users")->fetchAll(PDO::FETCH_ASSOC);
            $sets = [];
            $params = [];
            foreach ($colsInfo as $col) {
                $field = $col['Field'];
                if ($field === 'id') continue;
                if ($field === 'password') {
                    if (!empty($_POST['password'])) {
                        $sets[] = "$field = :$field";
                        $params[':' . $field] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    }
                } elseif (isset($_POST[$field])) {
                    $sets[] = "$field = :$field";
                    $params[':' . $field] = $_POST[$field];
                }
            }
            if (!empty($sets)) {
                $params[':id'] = $id;
                $sql = 'UPDATE users SET ' . implode(', ', $sets) . ' WHERE id = :id';
                $stmt = $this->userModel->pdo->prepare($sql);
                $stmt->execute($params);
            }
        }
        header('Location: ?mode=admin&action=list-users');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $this->userModel->pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$id]);
        }
        header('Location: ?mode=admin&action=list-users');
        exit;
    }
}
