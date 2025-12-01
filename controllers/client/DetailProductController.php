<?php
    class DetailProductController {
        private $productModel;

        public function __construct() {
            $this->productModel = new Product();
        }

        public function show() {
            $view = 'detail_product';
            $title = 'Chi tiết sản phẩm';
            try {
                if (!isset($_GET["id"])) {
                    throw new Exception('ID sản phẩm không tồn tại');
                }
                $id = $_GET["id"];
                // lấy thông tin chi tiết của sản phẩm
                $pro = $this->productModel->find($id);
                if (empty($pro)) {
                    throw new Exception("không tồn tại sản phẩm với id = $id");
                }
                    // thực thi cập nhật view_count
                $view_count = $pro['view_count'] + 1;
                // gọi csdl cập nhật view_count
                $this->productModel->updateViewCount($view_count, $id);
                
            } catch (Exception $ex) {
                throw new Exception('Lỗi không thể hiển thị chi tiết sản phẩm');
            }
            require_once PATH_VIEW_CLIENT_MAIN;
        }
    }
?>