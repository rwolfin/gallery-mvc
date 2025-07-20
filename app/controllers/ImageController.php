<?php
class ImageController {
    protected $imageModel;

    public function __construct() {
        $this->imageModel = new Image();
    }

    public function upload() {
        if (isset($_FILES['image']) && isset($_SESSION['user'])) {
            $this->imageModel->upload($_FILES['image']);
        }
        header("Location: /");
        exit;
    }

    public function delete() {
        if (isset($_POST['image_id']) && isset($_SESSION['user'])) {
            $this->imageModel->delete($_POST['image_id']);
        }
        header("Location: /");
        exit;
    }
}